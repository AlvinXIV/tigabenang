<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            BahanSeeder::class,
            UkuranSeeder::class,
            ProdukSeeder::class,
            ProdukBahanSeeder::class,
            PemesananSeeder::class,
        ]);
    }
}