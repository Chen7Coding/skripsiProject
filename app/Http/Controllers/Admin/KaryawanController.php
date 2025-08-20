<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Fungsi untuk menampilkan halaman tambah karyawan (jika diperlukan)
    public function create()
    {
        return view('admin.karyawan.create'); // Sesuaikan dengan path view Anda
    }

    // Fungsi untuk menyimpan data karyawan baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru dengan peran 'karyawan'
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'role' => 'karyawan', // Role diatur sebagai 'karyawan'
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }
}