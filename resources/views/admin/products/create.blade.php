@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('admin-content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" x-data="{ unit: '{{ old('unit', 'sqm') }}' }"
            class="space-y-6 bg-white p-6 rounded-xl shadow-lg border">
            @csrf

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm 
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('description') }}</textarea>
            </div>

            {{-- Unit --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Unit</label>
                <select name="unit" x-model="unit" required
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="sqm">Per m²</option>
                    <option value="sheet">Per Lembar</option>
                    <option value="book">Per Buku</option>
                    <option value="pcs">Per Pcs</option>
                </select>
            </div>

            {{-- Harga Dasar --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Harga Dasar</label>
                <input type="number" name="price" value="{{ old('price') }}" required min="0"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Harga per m² --}}
            <div x-show="unit === 'sqm'">
                <label class="block text-sm font-bold text-gray-700">Harga per m²</label>
                <input type="number" name="price_per_sqm" value="{{ old('price_per_sqm') }}" min="0"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Gambar Produk</label>
                <input type="file" name="image" accept="image/*"
                    class="mt-2 block w-full text-sm text-gray-600 rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Atribut Produk --}}
            <div class="border-t pt-6">
                <h2 class="text-lg font-bold mb-4">Atribut Produk</h2>

                <div id="attribute-container" class="space-y-4">
                    <div class="grid grid-cols-3 gap-4 items-center">
                        {{-- Material --}}
                        <select name="attributes[0][material]"
                            class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                   focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="" disabled selected>Pilih Material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material }}">{{ $material }}</option>
                            @endforeach
                        </select>

                        {{-- Ukuran --}}
                        <select name="attributes[0][size]"
                            class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                   focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="" disabled selected>Pilih Ukuran</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>

                        {{-- Harga Tambahan --}}
                        <input type="number" name="attributes[0][price_modifier]" placeholder="Harga Tambahan"
                            value="0"
                            class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                   focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <button type="button" onclick="addAttributeRow()"
                    class="mt-4 px-4 py-2 bg-amber-600 text-white font-semibold rounded-md shadow hover:bg-amber-700">
                    + Tambah Atribut
                </button>
            </div>

            {{-- Tombol Simpan --}}
            <div>
                <button type="submit"
                    class="px-6 py-3 bg-green-600 text-white font-bold rounded-md shadow-md hover:bg-green-700">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

    <script>
        let attributeIndex = 1;

        function addAttributeRow() {
            const container = document.getElementById('attribute-container');
            const row = document.createElement('div');
            row.classList.add('grid', 'grid-cols-3', 'gap-4', 'items-center', 'mt-2');
            row.innerHTML = `
                <select name="attributes[${attributeIndex}][material]" 
                    class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="" disabled selected>Pilih Material</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material }}">{{ $material }}</option>
                    @endforeach
                </select>

                <select name="attributes[${attributeIndex}][size]"
                    class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="" disabled selected>Pilih Ukuran</option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>

                <input type="number" name="attributes[${attributeIndex}][price_modifier]" placeholder="Harga Tambahan" value="0"
                    class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            `;
            container.appendChild(row);
            attributeIndex++;
        }
    </script>
@endsection
