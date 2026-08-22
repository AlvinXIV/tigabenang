<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukBahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produk_bahan')->insert([
            // Jaket Varsity → Fleece
            [
                'produk_id' => 1,
                'bahan_id' => 1,
            ],
            [
                'produk_id' => 2,
                'bahan_id' => 1,
            ],

            // Work Jacket → Drill
            [
                'produk_id' => 3,
                'bahan_id' => 3,
            ],

            // Windbreaker → Taslan
            [
                'produk_id' => 4,
                'bahan_id' => 4,
            ],
            [
                'produk_id' => 5,
                'bahan_id' => 4,
            ],

            // Jersey → Dry Fit
            [
                'produk_id' => 6,
                'bahan_id' => 5,
            ],

            // Kaos → Cotton Combed
            [
                'produk_id' => 7,
                'bahan_id' => 6,
            ],
            [
                'produk_id' => 8,
                'bahan_id' => 6,
            ],
        ]);
    }
}