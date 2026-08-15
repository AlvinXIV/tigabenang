<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = [
            'company_name' => 'Tigabenang Apparel & Confection',
            'tagline' => 'Solusi Vendor Pakaian Berkualitas dengan Teknologi Fitting 3D',
            'description' => 'Tigabenang adalah vendor konveksi dan manufaktur garmen modern yang melayani produksi jaket, hoodie, kaos kustom, jersey, dan seragam kemeja untuk instansi, korporat, komunitas, serta brand lokal. Dilengkapi teknologi 3D Virtual Fitting untuk akurasi ukuran maksimal.',
            'vision' => 'Menjadi pelopor vendor pakaian digital terdepan di Indonesia yang memberdayakan tenaga kerja lokal UMKM berlandaskan prinsip SDG 8.',
            'mission' => "1. Menyediakan produk pakaian berkualitas tinggi dengan standar jahitan garmen terbaik.\n2. Mengintegrasikan teknologi 3D Virtual Fitting untuk meminimalkan risiko retur dan salah ukuran.\n3. Memberikan pelayanan transparan, cepat, dan terpercaya bagi seluruh mitra bisnis.",
            'address' => 'Jl. Industri Kreatif No. 88, Cibaduyut, Bandung, Jawa Barat 40235',
            'phone' => '+62 22 7890 1234',
            'whatsapp' => '0812-3456-7890',
            'email' => 'contact@tigabenang.com',
            'instagram' => '@tigabenang.apparel',
            'website' => 'https://tigabenang.com',
        ];

        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        return redirect()->route('admin.profile.edit')->with('success', 'Profil perusahaan & kontak vendor berhasil diperbarui!');
    }
}
