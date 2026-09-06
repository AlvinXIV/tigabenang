<?php

namespace App\Support;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CustomerCatalog
{
    public const TTL_SECONDS = 600;

    public const KATEGORI_KEY = 'customer.catalog.kategori.rows';

    public const BAHAN_KEY = 'customer.catalog.bahan.rows';

    public const UKURAN_KEY = 'customer.catalog.ukuran.rows';

    public const HAS_3D_KEY = 'customer.catalog.has_3d';

    /**
     * Customer-facing category labels. Database values stay unchanged.
     *
     * @var array<string, string>
     */
    private const CATEGORY_LABELS = [
        'JaketWindbreaker' => 'Jaket Windbreaker',
    ];

    /**
     * Display-only material padding from existing catalog names.
     * Odd product IDs stop at 2; even product IDs use the third name when it exists.
     *
     * @var array<string, array<int, string>>
     */
    private const CATEGORY_PREVIEW_MATERIALS = [
        'Jaket Varsity' => ['Fleece', 'Cotton Combed', 'Baby Terry'],
        'Work Jacket' => ['Drill', 'Taslan', 'Fleece'],
        'JaketWindbreaker' => ['Taslan', 'Fleece', 'Drill'],
        'Jersey' => ['Dry Fit', 'Cotton Combed', 'Baby Terry'],
        'Kaos' => ['Cotton Combed', 'Baby Terry', 'Fleece'],
    ];

    public static function categoryLabel(?string $name): string
    {
        if ($name === null || $name === '') {
            return '';
        }

        return self::CATEGORY_LABELS[$name] ?? $name;
    }

    /**
     * Product Detail shows a mix of 2 and 3 materials without writing produk_bahan.
     * Related bahan come first. Even product IDs may add a third catalog material
     * from the established category mapping when that name already exists.
     *
     * @param  iterable<int, Bahan>|null  $related
     * @return Collection<int, Bahan>
     */
    public static function previewMaterials(
        iterable $related = [],
        ?string $categoryName = null,
        int|string|null $productId = null,
    ): Collection {
        $selected = collect($related)
            ->filter(fn ($bahan) => $bahan instanceof Bahan)
            ->unique(fn (Bahan $bahan) => $bahan->id_bahan)
            ->values();

        if ($selected->count() >= 3) {
            return $selected->take(3)->values();
        }

        $target = self::previewMaterialTarget($productId);

        if ($selected->count() >= $target) {
            return $selected->take($target)->values();
        }

        $catalog = self::materials();
        $seen = $selected
            ->map(fn (Bahan $bahan) => mb_strtolower(trim($bahan->nama_bahan)))
            ->all();

        $fallbackNames = array_merge(
            self::CATEGORY_PREVIEW_MATERIALS[$categoryName] ?? [],
            $catalog->pluck('nama_bahan')->all(),
        );

        foreach ($fallbackNames as $name) {
            if ($selected->count() >= $target) {
                break;
            }

            $match = $catalog->first(
                fn (Bahan $bahan) => mb_strtolower(trim($bahan->nama_bahan)) === mb_strtolower(trim((string) $name))
            );

            if (! $match) {
                continue;
            }

            $key = mb_strtolower(trim($match->nama_bahan));

            if (in_array($key, $seen, true)) {
                continue;
            }

            $selected->push($match);
            $seen[] = $key;
        }

        return $selected->take(3)->values();
    }

    private static function previewMaterialTarget(int|string|null $productId): int
    {
        $id = (int) $productId;

        if ($id > 0 && $id % 2 === 0) {
            return 3;
        }

        return 2;
    }

    public static function categories(): Collection
    {
        return once(function () {
            return Kategori::hydrate(self::rememberRows(self::KATEGORI_KEY, function () {
                return Kategori::query()
                    ->select(['id_kategori', 'nama_kategori'])
                    ->orderBy('nama_kategori')
                    ->get()
                    ->toArray();
            }));
        });
    }

    public static function materials(): Collection
    {
        return once(function () {
            return Bahan::hydrate(self::rememberRows(self::BAHAN_KEY, function () {
                return Bahan::query()
                    ->select(['id_bahan', 'nama_bahan'])
                    ->orderBy('nama_bahan')
                    ->get()
                    ->toArray();
            }));
        });
    }

    public static function sizes(): Collection
    {
        return once(function () {
            return Ukuran::hydrate(self::rememberRows(self::UKURAN_KEY, function () {
                return Ukuran::query()
                    ->select(['id_ukuran', 'kategori_id', 'nama_ukuran', 'lebar_dada', 'panjang', 'lebar_bahu', 'panjang_lengan'])
                    ->orderBy('id_ukuran')
                    ->get()
                    ->toArray();
            }));
        });
    }

    public static function hasThreeDProduct(): bool
    {
        return (bool) self::remember(self::HAS_3D_KEY, function () {
            return Produk::query()
                ->whereNotNull('file_model_3d')
                ->where('file_model_3d', '!=', '')
                ->exists();
        });
    }

    public static function attachKategori(mixed $products): void
    {
        $items = self::asProductCollection($products);

        if ($items->isEmpty()) {
            return;
        }

        $categories = self::categories()->keyBy('id_kategori');

        $items->each(function (Produk $produk) use ($categories) {
            $produk->setRelation('kategori', $categories->get($produk->kategori_id));
        });
    }

    public static function attachKategoriAndSizes(mixed $products): void
    {
        $items = self::asProductCollection($products);

        if ($items->isEmpty()) {
            return;
        }

        $categories = self::categories()->keyBy('id_kategori');
        $sizes = self::sizes()->groupBy('kategori_id');

        $items->each(function (Produk $produk) use ($categories, $sizes) {
            $kategori = $categories->get($produk->kategori_id);

            if ($kategori) {
                $kategori = clone $kategori;
                $kategori->setRelation('ukuran', $sizes->get($produk->kategori_id) ?? collect());
            }

            $produk->setRelation('kategori', $kategori);
        });
    }

    public static function flush(): void
    {
        Cache::forget(self::KATEGORI_KEY);
        Cache::forget(self::BAHAN_KEY);
        Cache::forget(self::UKURAN_KEY);
        Cache::forget(self::HAS_3D_KEY);
        Cache::forget('customer.catalog.kategori');
        Cache::forget('customer.catalog.bahan');
        Cache::forget('customer.catalog.ukuran');
    }

    /**
     * @param  callable(): array<int, array<string, mixed>>  $loader
     * @return array<int, array<string, mixed>>
     */
    private static function rememberRows(string $key, callable $loader): array
    {
        $rows = self::remember($key, $loader);

        return is_array($rows) ? $rows : [];
    }

    private static function remember(string $key, callable $loader): mixed
    {
        if (app()->runningUnitTests()) {
            return $loader();
        }

        return Cache::remember($key, self::TTL_SECONDS, $loader);
    }

    /**
     * @return Collection<int, Produk>
     */
    private static function asProductCollection(mixed $products): Collection
    {
        if ($products instanceof Produk) {
            return collect([$products]);
        }

        return collect($products)->filter(fn ($produk) => $produk instanceof Produk);
    }
}
