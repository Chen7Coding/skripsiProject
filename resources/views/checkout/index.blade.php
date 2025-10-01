@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="bg-gray-100 min-h-screen py-12" x-data="{
        subtotal: {{ $subtotal }},
        shippingCost: 0,
        get total() { return this.subtotal + this.shippingCost },
        async updateShippingCost(event) {
            const kecamatan = event.target.value;
            if (kecamatan) {
                // Panggil endpoint API untuk mendapatkan biaya pengiriman
                try {
                    const response = await fetch('{{ route('checkout.shipping-cost') }}?kecamatan=' + kecamatan);
                    const data = await response.json();
                    this.shippingCost = data.shipping_cost;
                } catch (error) {
                    console.error('Gagal mengambil biaya pengiriman:', error);
                    this.shippingCost = 0; // Atur ke 0 jika ada error
                }
            } else {
                this.shippingCost = 0;
            }
        },
        formatRupiah(value) {
            return 'Rp' + value.toLocaleString('id-ID');
        }
    }">

        <div class="container mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl
        lg:px-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 text-center mb-10">Menu Checkout</h2>

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

            <form action="{{ route('checkout.process') }}" method="POST"
                class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                @csrf
                {{-- INPUT HIDDEN UNTUK MENGIRIM BIAYA PENGIRIMAN KE CONTROLLER --}}
                <input type="hidden" name="shipping_cost" x-bind:value="shippingCost">
                <section aria-labelledby="contact-info-heading" class="lg:col-span-7">
                    {{-- INFORMASI KONTAK & PENGIRIMAN --}}
                    <div class="bg-white rounded-lg shadow-xl p-8 mb-8">
                        <h2 id="contact-info-heading" class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak &
                            Pengiriman
                        </h2>

                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Lengkap</label>
                                <div>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name ?? '') }}" autocomplete="name"
                                        class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                    Telepon</label>
                                <div>
                                    <input type="text" id="phone" name="phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}" autocomplete="tel"
                                        class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }}">
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                    Email</label>
                                <div>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}" autocomplete="email"
                                        class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                    Lengkap</label>
                                <div>
                                    <textarea id="address" name="address" rows="4"
                                        class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }}"
                                        placeholder="Nama Jalan, No. Rumah, RT/RW, Kelurahan/Desa">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dropdown Kecamatan -->
                            <div>
                                <label for="kecamatan"
                                    class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" required @change="updateShippingCost($event)"
                                    class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('kecamatan') ? 'border-red-500' : 'border-gray-300' }}">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->name }}"
                                            @if (old('kecamatan', auth()->user()->kecamatan ?? '') == $kecamatan->name) selected @endif>
                                            {{ $kecamatan->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Pos -->
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode
                                    Pos</label>
                                <div>
                                    <input type="text" id="postal_code" name="postal_code"
                                        value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}"
                                        autocomplete="postal-code"
                                        class="block w-full rounded-md py-2 px-3 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $errors->has('postal_code') ? 'border-red-500' : 'border-gray-300' }}">
                                </div>
                                @error('postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="bg-white rounded-lg shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Metode Pembayaran</h2>

                        {{-- Container untuk pilihan pembayaran dengan Alpine.js --}}
                        <div class="mt-4 space-y-4" x-data="{ selectedMethod: '{{ old('payment_method', 'Transfer Bank') }}' }">

                            {{-- Opsi 1: Transfer Bank --}}
                            <label for="payment_bank_transfer"
                                :class="selectedMethod === 'Transfer Bank' ? 'border-amber-500 ring-2 ring-amber-500' :
                                    'border-gray-300'"
                                class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-amber-400 transition-all duration-200">
                                <input type="radio" id="payment_bank_transfer" name="payment_method" value="Transfer Bank"
                                    x-model="selectedMethod"
                                    class="h-4 w-4 absolute top-4 left-4 text-amber-600 border-gray-300 focus:ring-amber-500 peer">
                                <span class="flex flex-1 ml-8">
                                    <span class="flex flex-col">
                                        <span
                                            class="block text-sm font-medium text-gray-900 peer-checked:text-amber-700">Transfer
                                            Bank</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">Pembayaran melalui
                                            transfer ke rekening bank kami.</span>
                                    </span>
                                </span>
                            </label>

                            {{-- Opsi 2: Pembayaran di Tempat (COD) --}}
                            <label for="payment_cod"
                                :class="selectedMethod === 'Pembayaran di Tempat (COD)' ?
                                    'border-amber-500 ring-2 ring-amber-500' : 'border-gray-300'"
                                class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-amber-400 transition-all duration-200">
                                <input type="radio" id="payment_cod" name="payment_method"
                                    value="Pembayaran di Tempat (COD)" x-model="selectedMethod"
                                    class="h-4 w-4 absolute top-4 left-4 text-amber-600 border-gray-300 focus:ring-amber-500 peer">
                                <span class="flex flex-1 ml-8">
                                    <span class="flex flex-col">
                                        <span
                                            class="block text-sm font-medium text-gray-900 peer-checked:text-amber-700">Pembayaran
                                            di Tempat (COD)</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">Bayar saat pesanan tiba
                                            di lokasi Anda.</span>
                                    </span>
                                </span>
                            </label>

                            {{-- Opsi 3: E-Wallet --}}
                            <label for="payment_e_wallet"
                                :class="selectedMethod === 'E-Wallet' ? 'border-amber-500 ring-2 ring-amber-500' :
                                    'border-gray-300'"
                                class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-amber-400 transition-all duration-200">
                                <input type="radio" id="payment_e_wallet" name="payment_method" value="E-Wallet"
                                    x-model="selectedMethod"
                                    class="h-4 w-4 absolute top-4 left-4 text-amber-600 border-gray-300 focus:ring-amber-500 peer">
                                <span class="flex flex-1 ml-8">
                                    <span class="flex flex-col">
                                        <span
                                            class="block text-sm font-medium text-gray-900 peer-checked:text-amber-700">E-Wallet</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">Pembayaran melalui
                                            aplikasi dompet digital.</span>
                                    </span>
                                </span>
                            </label>

                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <!-- Kolom Kanan: Ringkasan Pesanan -->
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
                                    Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="my-6 border-t border-gray-200"></div>

                    <dl class="space-y-4">
                        <div class="flex items-center justify-between text-gray-700">
                            <dt class="text-lg font-medium">Subtotal Produk</dt>
                            <dd class="text-lg font-bold text-gray-900">Rp{{ number_format($subtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-gray-700">
                            <dt class="text-lg font-medium">Biaya Pengiriman</dt>
                            <dd id="shipping-cost" class="text-lg font-bold text-gray-900"
                                x-text="formatRupiah(shippingCost)">
                                (dihitung saat checkout)</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-4 text-gray-900">
                            <dt class="text-2xl font-extrabold">Total Pesanan</dt>
                            <dd id="total-price" class="text-2xl font-extrabold text-amber-700"
                                x-text="formatRupiah(total)">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                    <div class="mt-8">
                        <button type="submit" name="submit"
                            class="w-full rounded-lg border border-transparent bg-amber-600 py-3.5 px-6 text-center text-xl font-bold text-white shadow-lg hover:bg-amber-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform hover:scale-105">
                            Buat Pesanan
                        </button>
                    </div>
                </section>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/js/checkout.js')
@endpush
