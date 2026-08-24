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

    /**
     * Local dummy images for the current 8-product development catalog.
     * Keys are produk.id_produk. Hero.jpg is intentionally excluded.
     *
     * @var array<int, string>
     */
    private const DEMO_PRODUCT_IMAGES = [
        1 => 'images/varsity.jpg',
        2 => 'images/Varsity_Maison_Sixth_June.jpg',
        3 => 'images/Work_jaket.jpg',
        4 => 'images/windbreaker.jpg',
        5 => 'images/windbreaker_2.jpg',
        6 => 'images/Jersey_Minimalist.jpg',
        7 => 'images/Kaos_Champions.jpg',
        8 => 'images/Kaos_Biru.jpg',
    ];

    public static function productImageUrl(object|int $produk, ?string $gambar = null): ?string
    {
        $id = is_object($produk) ? (int) ($produk->id_produk ?? 0) : $produk;
        $mapped = self::DEMO_PRODUCT_IMAGES[$id] ?? null;

        if ($mapped) {
            $url = self::imageUrl($mapped);

            if ($url) {
                return $url;
            }
        }

        $stored = $gambar ?? (is_object($produk) ? ($produk->gambar ?? null) : null);

        return self::imageUrl($stored);
    }

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
            return self::$imageUrlCache[$path] = self::browserUrl($normalized);
        }

        if (self::fileExists(public_path('storage/'.$normalized))) {
            return self::$imageUrlCache[$path] = self::browserUrl('storage/'.$normalized);
        }

        if (self::fileExists(storage_path('app/public/'.$normalized))) {
            return self::$imageUrlCache[$path] = self::browserUrl('storage/'.$normalized);
        }

        return self::$imageUrlCache[$path] = null;
    }

    public static function modelUrl(?string $path): ?string
    {
        return self::imageUrl($path);
    }

    /**
     * Local dummy images for current bahan records.
     * Keys are lowercase material names. Database names are not modified.
     *
     * @var array<string, string>
     */
    private const DEMO_MATERIAL_IMAGES = [
        'baby terry' => 'images/materials/baby_terry.jpg',
        'cotton combed' => 'images/materials/cotton_combed.jpg',
        'drill' => 'images/materials/drill.jpg',
        'dry fit' => 'images/materials/dryfit.png',
        'dryfit' => 'images/materials/dryfit.png',
        'dry-fit' => 'images/materials/dryfit.png',
        'fleece' => 'images/materials/fleece.jpg',
        'taslan' => 'images/materials/taslan.jpg',
    ];

    public static function materialImageUrl(string $namaBahan): ?string
    {
        $normalized = strtolower(trim(preg_replace('/\s+/', ' ', $namaBahan) ?? $namaBahan));
        $compact = preg_replace('/[\s\-_]+/', '', $normalized) ?? $normalized;
        $mapped = self::DEMO_MATERIAL_IMAGES[$normalized]
            ?? self::DEMO_MATERIAL_IMAGES[$compact]
            ?? null;

        if ($mapped) {
            $url = self::imageUrl($mapped);

            if ($url) {
                return $url;
            }
        }

        $index = self::materialFileIndex();

        if ($index === []) {
            return null;
        }

        $lookup = [];

        foreach ($index as $relative => $exists) {
            $lookup[strtolower((string) $relative)] = $relative;
        }

        $slug = str($normalized)->slug()->toString();
        $candidates = array_unique([
            $slug,
            str_replace('-', '_', $slug),
            str_replace('-', '', $slug),
        ]);

        foreach ($candidates as $name) {
            foreach (['jpg', 'png', 'webp'] as $extension) {
                $relative = strtolower("images/materials/{$name}.{$extension}");
                $actual = $lookup[$relative] ?? null;

                if ($actual) {
                    return self::browserUrl($actual);
                }
            }
        }

        return null;
    }

    public static function heroImageUrl(): ?string
    {
        $index = self::heroFileIndex();

        $lookup = [];

        foreach ($index as $relative => $exists) {
            $lookup[strtolower((string) $relative)] = $relative;
        }

        foreach (['images/hero.jpg', 'images/hero.png', 'images/hero.webp'] as $relative) {
            $actual = $lookup[strtolower($relative)] ?? null;

            if ($actual) {
                return self::browserUrl($actual);
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

    private static function browserUrl(string $relative): string
    {
        return '/'.ltrim($relative, '/');
    }

    private static function fileExists(string $absolutePath): bool
    {
        static $exists = [];

        return $exists[$absolutePath] ??= is_file($absolutePath);
    }
}
