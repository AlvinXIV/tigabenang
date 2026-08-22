<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produk')->insert([
            // Jaket Varsity
            [
                'kategori_id' => 1,
                'nama_produk' => 'Varsity HIMAMO',
                'harga' => 350000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Varsity Teknik Informatika',
                'harga' => 375000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Work Jacket
           
            [
                'kategori_id' => 2,
                'nama_produk' => 'Work Jacket Polman',
                'harga' => 425000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Windbreaker
            [
                'kategori_id' => 3,
                'nama_produk' => 'Windbreaker Alhilal',
                'harga' => 300000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'nama_produk' => 'Windbreaker HIMAMO',
                'harga' => 325000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jersey
           
            [
                'kategori_id' => 4,
                'nama_produk' => 'Jersey Futsal Polman',
                'harga' => 225000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kaos
            [
                'kategori_id' => 5,
                'nama_produk' => 'Kaos HIMAMO',
                'harga' => 150000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'nama_produk' => 'Kaos Informatika',
                'harga' => 140000,
                'gambar' => null,
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}