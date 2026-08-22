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
