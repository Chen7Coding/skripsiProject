@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-semibold mb-4">Tambah Produk</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block font-medium">Gambar</label>
                <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
@endsection
