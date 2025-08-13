@extends('layouts.owner')

@section('owner-content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Pengaturan Toko</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('owner.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="store_name" class="block text-sm font-medium text-gray-700">Nama Toko</label>
                        <input type="text" name="store_name" id="store_name"
                            value="{{ old('store_name', $setting->store_name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="store_email" class="block text-sm font-medium text-gray-700">Email Toko</label>
                        <input type="email" name="store_email" id="store_email"
                            value="{{ old('store_email', $setting->store_email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="store_contact" class="block text-sm font-medium text-gray-700">Kontak Toko (No.
                            WA)</label>
                        <input type="text" name="store_contact" id="store_contact"
                            value="{{ old('store_contact', $setting->store_contact) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="store_address" class="block text-sm font-medium text-gray-700">Alamat Toko</label>
                        <textarea name="store_address" id="store_address" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('store_address', $setting->store_address) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="store_logo" class="block text-sm font-medium text-gray-700">Logo Toko</label>
                        <div class="mt-1 flex items-center">
                            @if ($setting->store_logo)
                                <img src="{{ asset('storage/' . $setting->store_logo) }}" alt="Logo Toko"
                                    class="h-16 w-16 object-cover rounded-full mr-4">
                            @else
                                <span
                                    class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center mr-4 text-gray-500 text-xs">No
                                    Logo</span>
                            @endif
                            <input type="file" name="store_logo" id="store_logo"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
