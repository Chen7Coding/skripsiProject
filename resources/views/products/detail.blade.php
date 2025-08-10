@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-gray-100 py-12 antialiased">
        <div class="container mx-auto px-4 py-12 sm:py-16">
            {{-- Notifikasi Sukses/Error --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-400 bg-green-100 px-6 py-4 text-green-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-400 bg-red-100 px-6 py-4 text-red-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-2 lg:gap-x-12">

                {{-- Kolom Kiri: Gambar dan Deskripsi --}}
                <div>
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-100 shadow-xl">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center">
                    </div>
                    <div class="mt-10 p-6 bg-white rounded-lg shadow-xl">
                        <h2 class="text-xl font-extrabold text-gray-900">Deskripsi Produk</h2>
                        <div class="prose mt-4 max-w-none text-gray-700">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Pemesanan --}}
                <div class="flex flex-col p-6 bg-white rounded-lg shadow-xl">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ $product->name }}</h1>
                    <div class="mt-3">
                        <p class="text-4xl tracking-tight font-extrabold text-amber-600">
                            <span x-data="{ price: {{ $product->price }}, quantity: {{ old('quantity', $cartItem->quantity ?? 1) }} }"
                                x-text="'Rp' + new Intl.NumberFormat('id-ID').format(price * quantity)">
                                Rp{{ number_format($product->price * old('quantity', $cartItem->quantity ?? 1), 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10" x-data="{
                        designOption: '{{ old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') }}',
                    }">
                        <form
                            action="{{ isset($cartItem) ? route('cart.update', $cartItem->product_id) : route('cart.store') }}"
                            method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @if (isset($cartItem))
                                @method('PATCH')
                            @endif
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div>
                                <label class="text-base font-bold text-gray-900">Opsi Desain</label>
                                <fieldset class="mt-4">
                                    <div class="flex items-center gap-x-6">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-gray-500">
                                            <input type="radio" name="design_option" value="has_design"
                                                x-model="designOption"
                                                class="h-4 w-4 border-gray-300 text-gray-700 focus:ring-amber-700"
                                                {{ old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') == 'has_design' ? 'checked' : '' }}>
                                            <span class="ml-2">Sudah Punya Desain</span>
                                        </label>
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-gray-500">
                                            <input type="radio" name="design_option" value="no_design"
                                                x-model="designOption"
                                                class="h-4 w-4 border-gray-300 text-gray-700 focus:ring-gray-700"
                                                @checked(old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') == 'no_design')>
                                            <span class="ml-2">Belum Punya Desain</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <div x-show="designOption === 'has_design'" x-transition>
                                <label for="design_file_path" class="block text-sm font-bold text-gray-900">Upload File
                                    Desain</label>
                                <input id="design_file_path" name="design_file_path" type="file"
                                    class="mt-2 block w-full cursor-pointer text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-amber-100 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-amber-600 hover:file:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    accept=".jpg,.jpeg,.png,.pdf,.ai,.psd" />
                                @error('design_file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                @if (isset($cartItem) && $cartItem->design_file_path)
                                    <p class="mt-2 text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/' . $cartItem->design_file_path) }}" target="_blank"
                                            class="text-amber-600 hover:underline font-medium">Lihat File</a>. Upload baru
                                        untuk mengganti.
                                    </p>
                                @endif
                            </div>

                            <div x-show="designOption === 'no_design'" x-transition>
                                <label for="notes" class="block text-sm font-bold text-gray-900">Catatan untuk
                                    Desain</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm placeholder-gray-400"
                                    placeholder="Jelaskan desain yang Anda inginkan...">{{ old('notes', $cartItem->notes ?? '') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label for="material" class="block text-sm font-bold text-gray-900">Jenis Bahan</label>
                                    <select id="material" name="material"
                                        class="mt-2 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                        <option value="" disabled selected>Pilih Bahan</option>
                                        <option value="Flexi China"
                                            {{ old('material', $cartItem->material ?? '') == 'Flexi China' ? 'selected' : '' }}>
                                            Flexi China</option>
                                        <option value="Flexi Korea"
                                            {{ old('material', $cartItem->material ?? '') == 'Flexi Korea' ? 'selected' : '' }}>
                                            Flexi Korea</option>
                                        <option value="Albatros"
                                            {{ old('material', $cartItem->material ?? '') == 'Albatros' ? 'selected' : '' }}>
                                            Albatros</option>
                                    </select>
                                    @error('material')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="size" class="block text-sm font-bold text-gray-900">Ukuran</label>
                                    <input type="text" name="size" id="size"
                                        value="{{ old('size', $cartItem->size ?? '') }}"
                                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm placeholder-gray-400"
                                        placeholder="Contoh: 2x1 meter">
                                    @error('size')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-bold text-gray-900">Jumlah</label>
                                <input type="number" name="quantity"
                                    value="{{ $cartItem->quantity ?? old('quantity', 1) }}" min="1"
                                    class="mt-2 block w-full max-w-[120px] rounded-md border-gray-300 shadow-sm focus:border-amber-600 focus:ring-amber-700 sm:text-sm">
                                @error('quantity')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="mt-8 w-full rounded-md border border-transparent bg-amber-600 py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors duration-200">
                                {{ isset($cartItem) ? 'Update Keranjang' : 'Tambahkan ke Keranjang' }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
