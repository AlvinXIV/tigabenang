<?php

namespace App\Providers;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Ukuran;
use App\Support\CustomerCatalog;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $flushCatalog = fn () => CustomerCatalog::flush();

        Kategori::saved($flushCatalog);
        Kategori::deleted($flushCatalog);
        Bahan::saved($flushCatalog);
        Bahan::deleted($flushCatalog);
        Ukuran::saved($flushCatalog);
        Ukuran::deleted($flushCatalog);
        Produk::saved($flushCatalog);
        Produk::deleted($flushCatalog);
    }
}
