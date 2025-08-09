<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar karyawan.
     */
    public function index()
    {
        $employees = User::where('role', 'karyawan')->latest()->paginate(10);
        return view('owner.employees.index', compact('employees'));
    }

    /**
     * Menampilkan formulir untuk menambah karyawan baru.
     */
    public function create()
    {
        // View Path disesuaikan menjadi owner.employees.create
        return view('owner.employees.create');
    }

    /**
     * Menyimpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        return redirect()->route('owner.employee.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit data karyawan.
     */
    public function edit(User $employee)
    {
        // View Path disesuaikan menjadi owner.employees.edit
        return view('owner.employees.edit', compact('employee'));
    }

    /**
     * Memperbarui data karyawan di database.
     */
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $employee->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8',
        ]);

        $employee->name = $request->name;
        $employee->username = $request->username;
        $employee->email = $request->email;

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();

        return redirect()->route('owner.employee.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus karyawan dari database.
     */
    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('owner.employee.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}