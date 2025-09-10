<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $employees = User::where('role', 'karyawan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        // jika request AJAX (search), kembalikan partial table
        if ($request->ajax()) {
            return view('owner.employees.table', compact('employees'))->render();
        }

        return view('owner.employees.index', compact('employees', 'search'));
    }

    public function create()
    {
        return view('owner.employees.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'role'     => 'required|in:karyawan,admin',
    ]);

    // Generate username otomatis dari email
    $username = explode('@', $request->email)[0];

    // Generate password sementara
    $temporaryPassword = Str::random(10);

    $user = User::create([
        'name'     => $request->name,
        'username' => $username,
        'email'    => $request->email,
        'password' => Hash::make($temporaryPassword),
        'role'     => $request->role,
    ]);

    return redirect()->route('owner.employee.index')
        ->with('success', "Karyawan baru berhasil ditambahkan. Password sementara: {$temporaryPassword}");
}


    public function edit(User $employee)
    {
        return view('owner.employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'phone'    => 'nullable|string|max:20', // Perbaiki validasi
            'address'  => 'nullable|string', // Perbaiki validasi
            'role'     => 'required|in:karyawan,owner',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $employee->name     = $request->name;
        $employee->username = $request->username;
        $employee->email    = $request->email;
        $employee->phone    = $request->phone; // Tambahkan baris ini
        $employee->address  = $request->address; // Tambahkan baris ini
        $employee->role     = $request->role; // Tambahkan baris ini

        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();

        return redirect()->route('owner.employee.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('owner.employee.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
