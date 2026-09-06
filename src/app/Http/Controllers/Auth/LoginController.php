<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = trim($credentials['email']);
        $password = $credentials['password'];

        // Attempt login using username in PostgreSQL users table
        $attempt = Auth::attempt(['username' => $loginInput, 'password' => $password], $request->boolean('remember'));

        // Fallback: attempt using nama if username does not match
        if (! $attempt) {
            $attempt = Auth::attempt(['nama' => $loginInput, 'password' => $password], $request->boolean('remember'));
        }

        if ($attempt) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, Admin FitVendor!');
        }

        return back()->withInput($request->only('email'))->with('error', 'Username atau kata sandi tidak sesuai.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
