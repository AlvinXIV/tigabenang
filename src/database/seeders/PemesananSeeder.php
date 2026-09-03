<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemesananSeeder extends Seeder
{
    public function run(): void
    {
        $id1 = DB::table('pemesanan')->insertGetId([
            'nama' => 'Ahmad Fauzi',
            'alamat' => 'Jl. Asia Afrika No. 120, Bandung',
            'no_hp' => '081298765432',
            'produk_id' => 1,
            'total_harga' => 3500000,
            'upload_design' => null,
            'notes' => 'Tolong sablon logo komunitas di bagian dada.',
            'created_at' => now()->subDays(2),
        ], 'id_pemesanan');

        DB::table('pemesanan_material')->insert([
            ['pemesanan_id' => $id1, 'bahan_id' => 1],
        ]);

        DB::table('pemesanan_ukuran')->insert([
            ['pemesanan_id' => $id1, 'ukuran_id' => 1, 'kuantitas' => 5],
            ['pemesanan_id' => $id1, 'ukuran_id' => 2, 'kuantitas' => 5],
        ]);

        $id2 = DB::table('pemesanan')->insertGetId([
            'nama' => 'Dimas Pratama',
            'alamat' => 'Jl. Dago No. 45, Bandung',
            'no_hp' => '081322334455',
            'produk_id' => 3,
            'total_harga' => null, // Waiting price
            'upload_design' => null,
            'notes' => 'Warna furing hitam.',
            'created_at' => now()->subDays(1),
        ], 'id_pemesanan');

        DB::table('pemesanan_material')->insert([
            ['pemesanan_id' => $id2, 'bahan_id' => 3],
        ]);

        DB::table('pemesanan_ukuran')->insert([
            ['pemesanan_id' => $id2, 'ukuran_id' => 7, 'kuantitas' => 10],
        ]);

        $id3 = DB::table('pemesanan')->insertGetId([
            'nama' => 'Siti Nurhaliza',
            'alamat' => 'Jl. Ganesha No. 10, Bandung',
            'no_hp' => '081987654321',
            'produk_id' => 5,
            'total_harga' => 1500000,
            'upload_design' => null,
            'notes' => 'Acara Dies Natalis',
            'created_at' => now(),
        ], 'id_pemesanan');

        DB::table('pemesanan_material')->insert([
            ['pemesanan_id' => $id3, 'bahan_id' => 6],
        ]);

        DB::table('pemesanan_ukuran')->insert([
            ['pemesanan_id' => $id3, 'ukuran_id' => 16, 'kuantitas' => 10],
        ]);
    }
}
