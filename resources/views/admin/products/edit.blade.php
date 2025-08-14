@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Produk</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="description" class="block font-medium">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="price" class="block font-medium">Harga</label>
                <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}"
                    class="w-full border rounded px-3 py-2">
            </div>
            <label for="image" class="block font-medium">Gambar</label>
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="mb-2 w-32 rounded shadow">
            @else
                <img src="{{ asset('$product->image') }}" alt="Gambar Produk" class="mb-2 w-32 rounded shadow">
            @endif
            <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </div>
    </form>
    </div>
@endsection
