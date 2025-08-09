@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('admin-content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-4xl">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Pengaturan Profil</h1>
                <p class="mt-1 text-gray-500">Perbarui foto dan informasi pribadi Anda di sini.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-md border border-green-400 bg-green-100 px-4 py-3 text-green-700" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alpine.js untuk live preview gambar --}}
            <div x-data="{ photoPreview: '{{ $user->photo ? Storage::url($user->photo) : asset('image/default-avatar.png') }}' }">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-3">

                            <!-- =================================================== -->
                            <!-- ============== KOLOM KIRI: FOTO PROFIL ============ -->
                            <!-- =================================================== -->
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900">Foto Profil</h3>
                                <p class="mt-1 text-sm text-gray-500">Klik pada gambar untuk mengganti foto.</p>

                                <div class="mt-4">
                                    <input type="file" name="photo" id="photo" class="hidden"
                                        @change="photoPreview = URL.createObjectURL($event.target.files[0])">

                                    <label for="photo" class="cursor-pointer">
                                        <img :src="photoPreview" alt="Foto Profil"
                                            class="h-40 w-40 rounded-full object-cover ring-4 ring-gray-200 hover:ring-amber-500 transition-all">
                                    </label>
                                    @error('photo')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- =================================================== -->
                            <!-- ============== KOLOM KANAN: BIODATA =============== -->
                            <!-- =================================================== -->
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <!-- Nama -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $user->name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                                            required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Username -->
                                    <div>
                                        <label for="username"
                                            class="block text-sm font-medium text-gray-700">Username</label>
                                        <input type="text" name="username" id="username"
                                            value="{{ old('username', $user->username) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                                            required>
                                        @error('username')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="sm:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                                            required>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="sm:col-span-2">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor
                                            Telepon</label>
                                        <input type="text" name="phone" id="phone"
                                            value="{{ old('phone', $user->phone ?? '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                                            placeholder="Masukan Nomor Hp Anda">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Alamat Lengkap -->
                                    <div class="sm:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat
                                            Lengkap</label>
                                        <textarea name="address" id="address" rows="4"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                                            placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address ?? '') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-amber-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
