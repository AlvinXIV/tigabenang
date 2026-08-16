<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UkuranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        /*
        |--------------------------------------------------------------------------
        | Jaket Varsity
        |--------------------------------------------------------------------------
        */

        $ukuranVarsity = [
            ['S', 52, 66, 44, 60],
            ['M', 55, 68, 46, 61],
            ['L', 58, 70, 48, 62],
            ['XL', 61, 72, 50, 63],
            ['2XL', 64, 74, 52, 64],
        ];

        foreach ($ukuranVarsity as $ukuran) {
            $data[] = [
                'kategori_id' => 1,
                'nama_ukuran' => $ukuran[0],
                'lebar_dada' => $ukuran[1],
                'panjang' => $ukuran[2],
                'lebar_bahu' => $ukuran[3],
                'panjang_lengan' => $ukuran[4],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Work Jacket
        |--------------------------------------------------------------------------
        */

        $ukuranWorkJacket = [
            ['S', 54, 67, 45, 59],
            ['M', 57, 69, 47, 60],
            ['L', 60, 71, 49, 61],
            ['XL', 63, 73, 51, 62],
            ['2XL', 66, 75, 53, 63],
        ];

        foreach ($ukuranWorkJacket as $ukuran) {
            $data[] = [
                'kategori_id' => 2,
                'nama_ukuran' => $ukuran[0],
                'lebar_dada' => $ukuran[1],
                'panjang' => $ukuran[2],
                'lebar_bahu' => $ukuran[3],
                'panjang_lengan' => $ukuran[4],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Windbreaker
        |--------------------------------------------------------------------------
        */

        $ukuranWindbreaker = [
            ['S', 53, 67, 44, 61],
            ['M', 56, 69, 46, 62],
            ['L', 59, 71, 48, 63],
            ['XL', 62, 73, 50, 64],
            ['2XL', 65, 75, 52, 65],
        ];

        foreach ($ukuranWindbreaker as $ukuran) {
            $data[] = [
                'kategori_id' => 3,
                'nama_ukuran' => $ukuran[0],
                'lebar_dada' => $ukuran[1],
                'panjang' => $ukuran[2],
                'lebar_bahu' => $ukuran[3],
                'panjang_lengan' => $ukuran[4],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Jersey
        |--------------------------------------------------------------------------
        */

        $ukuranJersey = [
            ['S', 50, 68, 43, 21],
            ['M', 53, 70, 45, 22],
            ['L', 56, 72, 47, 23],
            ['XL', 59, 74, 49, 24],
            ['2XL', 62, 76, 51, 25],
        ];

        foreach ($ukuranJersey as $ukuran) {
            $data[] = [
                'kategori_id' => 4,
                'nama_ukuran' => $ukuran[0],
                'lebar_dada' => $ukuran[1],
                'panjang' => $ukuran[2],
                'lebar_bahu' => $ukuran[3],
                'panjang_lengan' => $ukuran[4],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Kaos
        |--------------------------------------------------------------------------
        */

        $ukuranKaos = [
            ['S', 48, 67, 42, 20],
            ['M', 51, 69, 44, 21],
            ['L', 54, 71, 46, 22],
            ['XL', 57, 73, 48, 23],
            ['2XL', 60, 75, 50, 24],
        ];

        foreach ($ukuranKaos as $ukuran) {
            $data[] = [
                'kategori_id' => 5,
                'nama_ukuran' => $ukuran[0],
                'lebar_dada' => $ukuran[1],
                'panjang' => $ukuran[2],
                'lebar_bahu' => $ukuran[3],
                'panjang_lengan' => $ukuran[4],
            ];
        }

        DB::table('ukuran')->insert($data);
    }
}