@extends('layouts.app')

@section('title', 'Pesan ' . $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Form Pemesanan</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Kolom Detail Produk -->
        <div class="md:col-span-1">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded-lg shadow-lg mb-4">
            <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
            <p class="text-lg text-gray-700 mt-2">{{ $product->description }}</p>
            <p class="text-2xl font-bold text-indigo-600 mt-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
        </div>

        <!-- Kolom Form Pemesanan -->
        <div class="md:col-span-2" x-data="{ designOption: 'has_design' }">
           <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-8 rounded-lg shadow-lg">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <!-- Opsi Desain -->
                <div>
                    <label class="text-base font-medium text-gray-900">Desain</label>
                    <p class="text-sm leading-5 text-gray-500">Apakah Anda sudah memiliki desain?</p>
                    <fieldset class="mt-4">
                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                            <div class="flex items-center">
                                <input id="has_design" name="design_option" type="radio" x-model="designOption" value="has_design" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="has_design" class="ml-3 block text-sm font-medium text-gray-700"> Sudah Punya Desain </label>
                            </div>
                            <div class="flex items-center">
                                <input id="no_design" name="design_option" type="radio" x-model="designOption" value="no_design" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="no_design" class="ml-3 block text-sm font-medium text-gray-700"> Belum Punya Desain </label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- Upload File (jika punya desain) -->
                <div x-show="designOption === 'has_design'" x-transition>
                    <label for="design_file" class="block text-sm font-medium text-gray-700">Upload File Desain</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <div class="flex text-sm text-gray-600"><label for="design_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"><span>Upload a file</span><input id="design_file" name="design_file" type="file" class="sr-only"></label><p class="pl-1">or drag and drop</p></div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF, CDR, PSD up to 10MB</p>
                        </div>
                    </div>
                </div>

                <!-- Catatan Pesanan (jika belum punya desain) -->
                <div x-show="designOption === 'no_design'" x-transition>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan untuk Desain</label>
                    <div class="mt-1">
                        <textarea id="notes" name="notes" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Jelaskan desain yang Anda inginkan. Contoh: Latar belakang merah, tulisan 'Selamat Datang' warna putih, ukuran besar di tengah."></textarea>
                    </div>
                </div>

                <!-- Detail Pesanan Lainnya -->
                <div>
                    <label for="material" class="block text-sm font-medium text-gray-700">Jenis Bahan</label>
                    <select id="material" name="material" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option>Flexi China</option>
                        <option>Flexi Korea</option>
                        <option>Albatros</option>
                    </select>
                </div>
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700">Ukuran</label>
                    <input type="text" name="size" id="size" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 2x1 meter atau A4">
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700">Tambahkan ke Keranjang</button>
            </form>
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
