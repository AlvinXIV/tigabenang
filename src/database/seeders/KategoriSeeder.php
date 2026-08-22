<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Jaket Varsity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Work Jacket',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'JaketWindbreaker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Jersey',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kaos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}