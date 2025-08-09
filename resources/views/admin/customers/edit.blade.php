@extends('layouts.admin')

@section('title', 'Edit Pelanggan')

@section('admin-content')
    <h3 class="text-gray-700 text-3xl font-medium">Edit Pelanggan: {{ $pelanggan->name }}</h3>

    <div class="mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.customers.update', $pelanggan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-700" for="name">Nama Lengkap</label>
                        <input class="form-input w-full mt-2 border border-gray-600 p-2 rounded-md focus:border-indigo-600"
                            type="text" name="name" value="{{ old('name', $pelanggan->name) }}">
                    </div>
                    <div>
                        <label class="text-gray-700" for="username">Username</label>
                        <input class="form-input w-full mt-2 rounded-md border border-gray-600 p-2 focus:border-indigo-600"
                            type="text" name="username" value="{{ old('username', $pelanggan->username) }}">
                    </div>
                    <div>
                        <label class="text-gray-700" for="email">Email</label>
                        <input class="form-input w-full mt-2 border border-gray-600 p-2 rounded-md focus:border-indigo-600"
                            type="email" name="email" value="{{ old('email', $pelanggan->email) }}">
                    </div>
                    <div>
                        <label class="text-gray-700" for="phone_number">Nomor Telepon</label>
                        <input class="form-input w-full mt-2 border border-gray-600 p-2rounded-md focus:border-indigo-600"
                            type="text" name="phone_number" value="{{ old('phone_number', $pelanggan->phone_number) }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-gray-700" for="address">Alamat</label>
                        <textarea class="form-textarea w-full mt-2 border border-gray-600 p-2 rounded-md focus:border-indigo-600" name="address"
                            rows="3">{{ old('address', $pelanggan->address) }}</textarea>
                    </div>
                    <div>
                        <label class="text-gray-700" for="password">Kata Sandi Baru (Opsional)</label>
                        <input class="form-input w-full mt-2 border border-gray-600 p-2 rounded-md focus:border-indigo-600"
                            type="password" name="password">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-blue-700">Perbarui
                        Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
