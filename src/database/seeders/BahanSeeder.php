<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bahan')->insert([
            [
                'nama_bahan' => 'Fleece',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bahan' => 'Baby Terry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bahan' => 'Drill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bahan' => 'Taslan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bahan' => 'Dry Fit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bahan' => 'Cotton Combed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}