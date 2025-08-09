<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Fungsi untuk menyimpan data pengguna baru
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Buat pengguna baru di database
        User::create([
            'name' => $request ->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => 'pelanggan', // Set role default
        ]);

        // 3. Arahkan pengguna ke halaman login setelah berhasil mendaftar
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}