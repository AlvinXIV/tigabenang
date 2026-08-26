<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = [
            'company_name' => 'Tigabenang Apparel & Confection',
            'tagline' => 'Solusi Vendor Pakaian Berkualitas dengan Teknologi Fitting 3D',
            'description' => 'Tigabenang adalah vendor konveksi dan manufaktur garmen modern yang melayani produksi jaket, hoodie, kaos kustom, jersey, dan seragam kemeja untuk instansi, korporat, komunitas, serta brand lokal. Dilengkapi teknologi 3D Virtual Fitting untuk akurasi ukuran maksimal.',
            'address' => 'Jl. Industri Kreatif No. 88, Cibaduyut, Bandung, Jawa Barat 40235',
            'phone' => '+62 22 7890 1234',
            'whatsapp' => '0812-3456-7890',
            'email' => $user ? $user->email : 'admin@tigabenang.com',
            'name' => $user ? $user->name : 'Admin Tigabenang',
        ];

        return view('admin.profile.index', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profil admin berhasil diperbarui!');
    }
}

