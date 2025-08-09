<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Fungsi untuk menangani proses login
    public function store(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember-me'))) {
        $request->session()->regenerate();

         // LOGIKA PENGALIHAN BERDASARKAN PERAN
        if (Auth::user()->role == 'pemilik') {
            return redirect()->route('home');
        }

        // LOGIKA PENGALIHAN BERDASARKAN PERAN
        if (Auth::user()->role == 'karyawan') {
            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
        'username' => 'Username atau password yang diberikan salah.',
    ])->onlyInput('username');
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
