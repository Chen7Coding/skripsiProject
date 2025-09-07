<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
     // Fungsi untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Fungsi untuk menangani proses login
    public function store(Request $request)
{
   // 1. Validasi input: gunakan email dan password
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => 'required|string',
        ]);
        
        // 2. Coba autentikasi pengguna
    if (Auth::attempt($credentials, $request->boolean('remember-me'))) {
        $request->session()->regenerate();

         // 3 LOGIKA PENGALIHAN BERDASARKAN PERAN
        if (Auth::user()->role == 'pemilik') {
            return redirect()->route('home');
        }

        // LOGIKA PENGALIHAN BERDASARKAN PERAN
        if (Auth::user()->role == 'karyawan') {
            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

   // 4. Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
}

    // Fungsi untuk menangani proses logout
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
