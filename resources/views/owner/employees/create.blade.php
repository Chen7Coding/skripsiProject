@extends('layouts.owner')

@section('title', 'Tambah Karyawan')

@section('owner-content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Karyawan Baru</h2>

        <form action="{{ route('owner.employee.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div class="flex items-center">
                <label for="name" class="w-32 text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="flex-1 p-2 border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>

            {{-- Email --}}
            <div class="flex items-center">
                <label for="email" class="w-32 text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="flex-1 p-2 border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>

            {{-- Role --}}
            <div class="flex items-center">
                <label for="role" class="w-32 text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role"
                    class="flex-1 p-2 border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('owner.employee.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
