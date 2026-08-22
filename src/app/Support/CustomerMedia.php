<?php

namespace App\Support;

class CustomerMedia
{
    /**
     * @var array<string, bool>|null
     */
    private static ?array $materialFileIndex = null;

    /**
     * @var array<string, bool>|null
     */
    private static ?array $heroFileIndex = null;

    /**
     * @var array<string, ?string>
     */
    private static array $imageUrlCache = [];

    public static function imageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (isset(self::$imageUrlCache[$path])) {
            return self::$imageUrlCache[$path];
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return self::$imageUrlCache[$path] = $path;
        }

        $normalized = ltrim($path, '/');

        if (self::fileExists(public_path($normalized))) {
            return self::$imageUrlCache[$path] = asset($normalized);
        }

        if (self::fileExists(public_path('storage/'.$normalized))) {
            return self::$imageUrlCache[$path] = asset('storage/'.$normalized);
        }

        if (self::fileExists(storage_path('app/public/'.$normalized))) {
            return self::$imageUrlCache[$path] = asset('storage/'.$normalized);
        }

        return self::$imageUrlCache[$path] = null;
    }

    public static function modelUrl(?string $path): ?string
    {
        return self::imageUrl($path);
    }

    public static function materialImageUrl(string $namaBahan): ?string
    {
        $index = self::materialFileIndex();

        if ($index === []) {
            return null;
        }

        $slug = str($namaBahan)->slug()->toString();

        foreach (['jpg', 'png', 'webp'] as $extension) {
            $relative = "images/materials/{$slug}.{$extension}";

            if (isset($index[$relative])) {
                return asset($relative);
            }
        }

        return null;
    }

    public static function heroImageUrl(): ?string
    {
        $index = self::heroFileIndex();

        foreach (['images/hero.jpg', 'images/hero.png', 'images/hero.webp'] as $relative) {
            if (isset($index[$relative])) {
                return asset($relative);
            }
        }

        return null;
    }

    /**
     * @return array<string, bool>
     */
    private static function materialFileIndex(): array
    {
        if (self::$materialFileIndex !== null) {
            return self::$materialFileIndex;
        }

        return self::$materialFileIndex = self::publicImageIndex('images/materials');
    }

    /**
     * @return array<string, bool>
     */
    private static function heroFileIndex(): array
    {
        if (self::$heroFileIndex !== null) {
            return self::$heroFileIndex;
        }

        return self::$heroFileIndex = self::publicImageIndex('images');
    }

    /**
     * @return array<string, bool>
     */
    private static function publicImageIndex(string $relativeDirectory): array
    {
        $directory = public_path($relativeDirectory);

        if (! is_dir($directory)) {
            return [];
        }

        $index = [];

        foreach (scandir($directory) ?: [] as $file) {
            if ($file === '.' || $file === '..' || $file === '.gitkeep') {
                continue;
            }

            $index[$relativeDirectory.'/'.$file] = true;
        }

        return $index;
    }

    private static function fileExists(string $absolutePath): bool
    {
        static $exists = [];

        return $exists[$absolutePath] ??= is_file($absolutePath);
    }
}
