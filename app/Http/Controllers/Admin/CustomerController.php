<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'pelanggan')->latest()->paginate(10);
        return view('admin.customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'pelanggan',
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    // FUNGSI UNTUK MENAMPILKAN HALAMAN EDIT (DIPERBAIKI)
    public function edit(User $pelanggan)
    {
        return view('admin.customers.edit', ['pelanggan' => $pelanggan]);
    }

    // FUNGSI UNTUK MEMPROSES PEMBARUAN DATA
    public function update(Request $request, User $pelanggan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $pelanggan->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $pelanggan->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $pelanggan->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // FUNGSI UNTUK MENGHAPUS DATA
    public function destroy(User $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
