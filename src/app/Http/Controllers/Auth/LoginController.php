<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Demo redirect into admin dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin Tigabenang!');
    }

    public function logout()
    {
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
