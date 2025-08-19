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

        {{-- Form Edit Produk Utama --}}
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
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
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="image" class="block font-medium">Gambar</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk"
                        class="mb-2 w-32 rounded shadow">
                @else
                    <span class="text-gray-400">Tidak Ada Gambar</span>
                @endif
                <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2">
            </div>

            <hr class="my-6">

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.products.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>

        <hr class="my-6">

        {{-- Form untuk Menambah Opsi Dinamis --}}
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Opsi Produk</h3>
        <form action="{{ route('admin.products.options.store', $product) }}" method="POST"
            class="flex flex-col md:flex-row gap-4">
            @csrf
            <div class="flex-1">
                <select name="option_type" class="block w-full border rounded px-3 py-2">
                    <option value="material">Material</option>
                    <option value="size">Ukuran</option>
                    <option value="finishing">Finishing</option>
                </select>
            </div>
            <div class="flex-1">
                <input type="text" name="value" placeholder="Nama Opsi" class="block w-full border rounded px-3 py-2">
            </div>
            <div class="flex-1">
                <input type="number" name="price_modifier" placeholder="Harga Tambahan (mis: 5000)"
                    class="block w-full border rounded px-3 py-2">
            </div>
            <div class="flex-shrink-0">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto">Tambah</button>
            </div>
        </form>

        <hr class="my-6">

        {{-- Tabel untuk Menampilkan Opsi yang Sudah Ada --}}
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi Tersedia</h3>
        <div class="overflow-x-auto">
            @if ($product->productOptions && $product->productOptions->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opsi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                                Tambahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($product->productOptions as $option)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($option->option_type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $option->value }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp{{ number_format($option->price_modifier, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.products.options.destroy', $option) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">Belum ada opsi produk untuk produk ini. Gunakan formulir di atas untuk
                    menambahkannya.</p>
            @endif
        </div>
    </div>
@endsection
