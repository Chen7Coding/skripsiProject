@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('admin-content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6 shadow">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
            x-data="{ unit: '{{ old('unit', $product->unit) }}' }" class="space-y-6 bg-white p-6 rounded-xl shadow-lg border">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Unit --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Unit</label>
                <select name="unit" x-model="unit" required
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    <option value="sqm" @selected(old('unit', $product->unit) === 'sqm')>Per m²</option>
                    <option value="sheet" @selected(old('unit', $product->unit) === 'sheet')>Per Lembar</option>
                    <option value="book" @selected(old('unit', $product->unit) === 'book')>Per Buku</option>
                    <option value="pcs" @selected(old('unit', $product->unit) === 'pcs')>Per Pcs</option>
                </select>
            </div>

            {{-- Harga Dasar --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Harga Dasar</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Harga per m² --}}
            <div x-show="unit === 'sqm'">
                <label class="block text-sm font-bold text-gray-700">Harga per m²</label>
                <input type="number" name="price_per_sqm" value="{{ old('price_per_sqm', $product->price_per_sqm) }}"
                    min="0"
                    class="mt-2 block w-full rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label class="block text-sm font-bold text-gray-700">Gambar Produk</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk"
                        class="mb-3 w-32 rounded-md shadow-md border">
                @endif
                <input type="file" name="image" accept="image/*"
                    class="mt-2 block w-full text-sm text-gray-600 rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            {{-- Atribut Produk --}}
            <div class="border-t pt-6">
                <h2 class="text-lg font-bold mb-4">Atribut Produk</h2>

                <div id="attribute-container" class="space-y-4">
                    @foreach ($product->attributes as $i => $attribute)
                        <div class="grid grid-cols-3 gap-4 items-center">
                            {{-- Hidden ID supaya updateOrCreate bisa jalan --}}
                            <input type="hidden" name="attributes[{{ $i }}][id]" value="{{ $attribute->id }}">

                            {{-- Material --}}
                            <select name="attributes[{{ $i }}][material]"
                                class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                       focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="" disabled>Pilih Material</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material }}" @selected($attribute->material === $material)>
                                        {{ $material }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Ukuran --}}
                            <select name="attributes[{{ $i }}][size]"
                                class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                       focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="" disabled>Pilih Ukuran</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size }}" @selected($attribute->size === $size)>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Harga Tambahan --}}
                            <input type="number" name="attributes[{{ $i }}][price_modifier]"
                                value="{{ $attribute->price_modifier ?? 0 }}" placeholder="Harga Tambahan"
                                class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                                       focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    @endforeach
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
                    Simpan Perubahan
                </button>
                <a href="{{ route('products.index') }}" class="ml-3 text-gray-600 font-medium hover:underline">Batal</a>
            </div>
        </form>
    </div>

    <script>
        let attributeIndex = {{ count($product->attributes) }};

        function addAttributeRow() {
            const container = document.getElementById('attribute-container');
            const row = document.createElement('div');
            row.classList.add('grid', 'grid-cols-3', 'gap-4', 'items-center', 'mt-2');
            row.innerHTML = `
                <input type="hidden" name="attributes[${attributeIndex}][id]" value="">
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

                <input type="number" name="attributes[${attributeIndex}][price_modifier]" value="0" placeholder="Harga Tambahan"
                    class="rounded-md border border-gray-400 bg-gray-50 shadow-sm
                           focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            `;
            container.appendChild(row);
            attributeIndex++;
        }
    </script>
@endsection
