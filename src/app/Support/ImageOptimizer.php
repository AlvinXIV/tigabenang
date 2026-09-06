<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class ImageOptimizer
{
    /**
     * Convert an image in storage to WebP format.
     *
     * @param string $storageRelativePath Relative path in the specified storage disk (e.g., 'produk/image.jpg')
     * @param string $disk Storage disk name (default 'public')
     * @param int $quality WebP quality level (0-100, default 82)
     * @return string|null The relative path to the generated WebP file, or null on failure
     */
    public static function convertToWebp(string $storageRelativePath, string $disk = 'public', int $quality = 82): ?string
    {
        $storage = Storage::disk($disk);

        if (! $storage->exists($storageRelativePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($storageRelativePath, PATHINFO_EXTENSION));

        // If it's already a WebP image, nothing to convert
        if ($extension === 'webp') {
            return $storageRelativePath;
        }

        $webpRelativePath = self::getWebpRelativePath($storageRelativePath);
        $isCloud = in_array($disk, ['supabase', 's3']) || in_array(config("filesystems.disks.{$disk}.driver"), ['s3', 'ftp', 'sftp']);
        $sourceFullPath = '';
        $targetFullPath = '';

        if (! $isCloud) {
            try {
                $sourceFullPath = $storage->path($storageRelativePath);
                $targetFullPath = $storage->path($webpRelativePath);

                if (! file_exists($sourceFullPath)) {
                    $isCloud = true;
                } else {
                    $targetDir = dirname($targetFullPath);
                    if (! is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                }
            } catch (\Throwable $e) {
                $isCloud = true;
            }
        }

        if ($isCloud) {
            $tempDir = sys_get_temp_dir();
            $sourceFullPath = $tempDir . '/' . uniqid('img_src_', true) . '.' . $extension;
            $targetFullPath = $tempDir . '/' . uniqid('img_dst_', true) . '.webp';
            file_put_contents($sourceFullPath, $storage->get($storageRelativePath));
        }

        // 1. Primary engine: cwebp CLI utility
        try {
            $process = Process::run(['cwebp', '-q', (string) $quality, $sourceFullPath, '-o', $targetFullPath]);

            if ($process->successful() && file_exists($targetFullPath) && filesize($targetFullPath) > 0) {
                if ($isCloud) {
                    $storage->put($webpRelativePath, file_get_contents($targetFullPath));
                    @unlink($sourceFullPath);
                    @unlink($targetFullPath);
                } else {
                    @chmod($targetFullPath, 0644);
                }

                return $webpRelativePath;
            }
        } catch (\Throwable $e) {
            Log::warning("ImageOptimizer: cwebp execution error: " . $e->getMessage());
        }

        // 2. Fallback engine: PHP GD with WebP support
        if (function_exists('imagewebp')) {
            try {
                $image = null;
                if (in_array($extension, ['jpg', 'jpeg'])) {
                    $image = @imagecreatefromjpeg($sourceFullPath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($sourceFullPath);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                }

                if ($image) {
                    $saved = @imagewebp($image, $targetFullPath, $quality);
                    imagedestroy($image);

                    if ($saved && file_exists($targetFullPath) && filesize($targetFullPath) > 0) {
                        if ($isCloud) {
                            $storage->put($webpRelativePath, file_get_contents($targetFullPath));
                            @unlink($sourceFullPath);
                            @unlink($targetFullPath);
                        } else {
                            @chmod($targetFullPath, 0644);
                        }

                        return $webpRelativePath;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("ImageOptimizer: GD fallback error: " . $e->getMessage());
            }
        }

        if ($isCloud) {
            if (file_exists($sourceFullPath)) {
                @unlink($sourceFullPath);
            }
            if (file_exists($targetFullPath)) {
                @unlink($targetFullPath);
            }
        }

        return null;
    }

    /**
     * Delete an image and its corresponding WebP version from storage if it exists.
     *
     * @param string|null $storageRelativePath
     * @param string $disk
     */
    public static function deleteWithWebp(?string $storageRelativePath, string $disk = 'public'): void
    {
        if (! $storageRelativePath) {
            return;
        }

        $storage = Storage::disk($disk);

        if ($storage->exists($storageRelativePath)) {
            $storage->delete($storageRelativePath);
        }

        $webpRelativePath = self::getWebpRelativePath($storageRelativePath);

        if ($webpRelativePath !== $storageRelativePath && $storage->exists($webpRelativePath)) {
            $storage->delete($webpRelativePath);
        }
    }

    /**
     * Get the relative WebP path counterpart for a given file path.
     */
    public static function getWebpRelativePath(string $path): string
    {
        $info = pathinfo($path);
        $dirname = ($info['dirname'] === '.' || $info['dirname'] === '/') ? '' : $info['dirname'] . '/';

        return $dirname . $info['filename'] . '.webp';
    }

    /**
     * Get public browser URL for the WebP version if it exists in storage.
     */
    public static function getWebpUrl(?string $storageRelativePath, string $disk = 'public'): ?string
    {
        if (! filled($storageRelativePath)) {
            return null;
        }

        $storage = Storage::disk($disk);
        $webpRelativePath = self::getWebpRelativePath($storageRelativePath);

        if ($storage->exists($webpRelativePath)) {
            return $storage->url($webpRelativePath);
        }

        return null;
    }
}
