@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="bg-gray-100 min-h-screen py-12">
        <div class="container mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 text-center mb-10">Keranjang Belanja Anda</h1>

            {{-- Notifikasi sukses / error --}}
            @if (session('success'))
                <div class="mt-6 rounded-lg border border-green-400 bg-green-100 px-6 py-4 text-green-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mt-6 rounded-lg border border-red-400 bg-red-100 px-6 py-4 text-red-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('error') }}</p>
                </div>
            @endif

            @if ($cartItems->count() > 0)
                <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    {{-- Daftar item keranjang --}}
                    <section aria-labelledby="cart-items-heading"
                        class="lg:col-span-7 bg-white rounded-lg shadow-xl p-6 sm:p-8">
                        <h2 class="sr-only">Items in your shopping cart</h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($cartItems as $item)
                                <li class="flex flex-col sm:flex-row py-6 sm:py-8 sm:items-start">
                                    {{-- Gambar produk --}}
                                    <div
                                        class="flex-shrink-0 relative w-28 h-28 sm:w-36 sm:h-36 rounded-md overflow-hidden border border-gray-200">
                                        <a href="{{ route('products.show', ['product' => $item->product->slug ?? '#']) }}"
                                            class="block w-full h-full">
                                            <img src="{{ $item->design_file_path ? Storage::url($item->design_file_path) : asset('storage/' . $item->product->image) }}"
                                                alt="{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}"
                                                class="w-full h-full object-cover object-center transition-transform duration-300 hover:scale-105">
                                        </a>
                                    </div>

                                    {{-- Detail produk --}}
                                    <div class="sm:ml-5 flex-1 flex flex-col justify-between mt-4 sm:mt-0">
                                        <div class="relative sm:grid sm:grid-cols-2 sm:gap-x-6">
                                            <div>
                                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                                                    <a href="{{ route('products.show', ['product' => $item->product->slug ?? '#']) }}"
                                                        class="hover:text-amber-600 transition-colors duration-200">
                                                        {{ $item->product->name ?? 'Produk Tidak Ditemukan' }}
                                                    </a>
                                                </h3>
                                                <dl class="mt-1 space-y-1 text-sm text-gray-600">
                                                    <div>
                                                        <dt class="inline font-medium">Bahan:</dt>
                                                        <dd class="inline ml-1">{{ $item->material ?? '-' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="inline font-medium">Ukuran:</dt>
                                                        <dd class="inline ml-1">{{ $item->size ?? '-' }}</dd>
                                                        @if ($item->length && $item->width)
                                                            <dd class="block text-xs text-gray-500">
                                                                ({{ $item->length }}cm x {{ $item->width }}cm)
                                                            </dd>
                                                        @endif
                                                    </div>
                                                    @if ($item->notes)
                                                        <div class="mt-1">
                                                            <dt class="inline font-medium">Catatan:</dt>
                                                            <dd class="inline ml-1">{{ Str::limit($item->notes, 40) }}</dd>
                                                        </div>
                                                    @endif
                                                </dl>
                                            </div>

                                            {{-- Harga + Update qty --}}
                                            <div class="mt-4 sm:mt-0 flex flex-col items-end">
                                                <p class="text-lg sm:text-2xl font-extrabold text-amber-700 mb-2">
                                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                                </p>
                                                <div class="w-full max-w-[150px]">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                        class="flex items-center justify-end">
                                                        @csrf
                                                        @method('PATCH')
                                                        {{-- Data tambahan (hidden) --}}
                                                        <input type="hidden" name="material"
                                                            value="{{ $item->material }}">
                                                        <input type="hidden" name="size_option_type"
                                                            value="{{ $item->length ? 'custom' : 'predefined' }}">
                                                        <input type="hidden" name="size" value="{{ $item->size }}">
                                                        <input type="hidden" name="custom_length"
                                                            value="{{ $item->length }}">
                                                        <input type="hidden" name="custom_width"
                                                            value="{{ $item->width }}">
                                                        <input type="hidden" name="notes" value="{{ $item->notes }}">
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $item->product->id }}">


                                                        {{-- Input jumlah --}}
                                                        {{-- Flag agar controller tahu ini quick update --}}
                                                        <input type="hidden" name="quick_update" value="1">
                                                        <label for="quantity-{{ $item->id }}"
                                                            class="sr-only">Jumlah</label>
                                                        <input type="number" id="quantity-{{ $item->id }}"
                                                            name="quantity" value="{{ $item->quantity }}" min="1"
                                                            class="w-full rounded-md border-gray-300 py-1.5 text-center text-base shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                                        <button type="submit"
                                                            class="ml-2 px-3 py-1.5 rounded-md bg-amber-600 text-white font-semibold shadow-md hover:bg-amber-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                            Update
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Subtotal + Tombol Edit/Hapus --}}
                                        <div
                                            class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between text-base border-t border-gray-100 pt-4">
                                            <p class="font-semibold text-gray-900">
                                                Subtotal Item:
                                                <span class="text-amber-600">
                                                    Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                </span>
                                            </p>
                                            <div class="flex space-x-2 mt-2 sm:mt-0">
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('products.show', ['product' => $item->product->slug, 'edit_cart_item' => $item->id]) }}"
                                                    class="px-3 py-1.5 rounded-md bg-gray-500 text-white font-semibold shadow-md hover:bg-gray-700 transition-colors duration-200">Edit</a>
                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('cart.remove', $item->product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 rounded-md bg-red-500 text-white font-semibold shadow-md hover:bg-red-700 transition-colors duration-200">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    {{-- Rincian Pesanan --}}
                    <section aria-labelledby="summary-heading"
                        class="mt-16 rounded-lg bg-white shadow-xl p-8 lg:col-span-5 lg:mt-0">
                        <h2 id="summary-heading" class="text-2xl font-bold text-gray-900 mb-6">Rincian Pesanan</h2>

                        <dl class="mt-6 space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="flex items-start justify-between text-gray-700">
                                    <dt class="text-base">
                                        <span>{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</span>
                                        <span class="mt-1 block text-sm text-gray-500">{{ $item->quantity }} x
                                            Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                    </dt>
                                    <dd class="text-base font-medium text-gray-900">
                                        Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>

                        <div class="my-6 border-t border-gray-200"></div>

                        <dl class="space-y-4">
                            <div class="flex items-center justify-between text-gray-700">
                                <dt class="text-lg font-medium">Subtotal Produk</dt>
                                <dd class="text-lg font-bold text-gray-900">Rp{{ number_format($subtotal, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between text-gray-700">
                                <dt class="text-lg font-medium">Biaya Pengiriman</dt>
                                <dd class="text-lg font-medium text-gray-500">(dihitung saat checkout)</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-gray-900">
                                <dt class="text-2xl font-extrabold">Total Pesanan</dt>
                                <dd class="text-2xl font-extrabold text-amber-700">
                                    Rp{{ number_format($total, 0, ',', '.') }}
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}"
                                class="w-full rounded-lg border border-transparent bg-amber-600 py-3.5 px-6 text-center text-xl font-bold text-white shadow-lg hover:bg-amber-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform hover:scale-105">
                                Checkout
                            </a>
                        </div>
                    </section>
                </div>
            @else
                {{-- Jika keranjang kosong --}}
                <div class="mt-16 rounded-lg bg-white p-16 text-center shadow-xl border border-gray-200">
                    <p class="text-2xl text-gray-700 font-semibold mb-6">Keranjang belanja Anda masih kosong.</p>
                    <a href="{{ route('produk') }}"
                        class="inline-block rounded-lg bg-amber-600 py-3.5 px-10 font-bold text-white shadow-lg hover:bg-amber-700 transition-colors duration-200 transform hover:scale-105">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
