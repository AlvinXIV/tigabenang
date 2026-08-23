<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'kategori_id' => 1,
                'nama_produk' => 'Heritage Varsity',
                'harga' => 350000,
                'gambar' => 'images/varsity.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Maison Varsity',
                'harga' => 375000,
                'gambar' => 'images/Varsity_Maison_Sixth_June.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'nama_produk' => 'Utility Work Jacket',
                'harga' => 425000,
                'gambar' => 'images/Work_jaket.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'nama_produk' => 'Urban Windbreaker',
                'harga' => 300000,
                'gambar' => 'images/windbreaker.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'nama_produk' => 'Aero Shell Windbreaker',
                'harga' => 325000,
                'gambar' => 'images/windbreaker_2.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'nama_produk' => 'Aero Match Jersey',
                'harga' => 225000,
                'gambar' => 'images/Jersey_Minimalist.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'nama_produk' => 'Noir Crest Tee',
                'harga' => 150000,
                'gambar' => 'images/Kaos_Champions.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'nama_produk' => 'Cobalt Essential Tee',
                'harga' => 140000,
                'gambar' => 'images/Kaos_Biru.jpg',
                'file_model_3d' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
