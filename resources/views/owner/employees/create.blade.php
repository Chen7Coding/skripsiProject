@extends('layouts.owner')
@section('title', 'Tambah Karyawan')
@section('owner-content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Tambah Karyawan Baru</h2>
        <form action="{{ route('owner.employee.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name"
                    class="mt-1 p-2 w-full border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username"
                    class="mt-1 p-2 w-full border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 p-2 w-full border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 p-2 w-full border rounded-md focus:ring-gray-500 focus:border-gray-500" required>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('owner.employee.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
