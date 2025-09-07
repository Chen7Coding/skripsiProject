@extends('layouts.owner')

@section('title', 'Edit Karyawan')

@section('owner-content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 text-center mb-10">Edit Karyawan</h2>

        <form action="{{ route('owner.employee.update', $employee) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $employee->username) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    required>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor HP --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="address" name="address" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('address', $employee->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    required>
                    <option value="karyawan" {{ old('role', $employee->role) == 'karyawan' ? 'selected' : '' }}>Karyawan
                    </option>
                    <option value="pemilik" {{ old('role', $employee->role) == 'pemilik' ? 'selected' : '' }}>Pemilik
                    </option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                    placeholder="Biarkan kosong jika tidak ingin mengubah password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('owner.employee.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">Update</button>
            </div>
        </form>
    </div>
@endsection
