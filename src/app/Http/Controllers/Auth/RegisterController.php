<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        // Simple frontend redirect/mock behavior without modifying backend auth/DB
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk dengan email Anda.');
    }
}
