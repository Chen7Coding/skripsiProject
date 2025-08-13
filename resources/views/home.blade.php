@extends('layouts.app')

@section('title', 'Selamat Datang di Sidu Digital Print')

@section('content')
    <!-- Bagian Hero -->
    <div class="w-full flex items-center justify-center" style="min-height: calc(100vh - 4rem);">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap items-center">
                <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/2 md:pr-12">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                        SIDU DIGITAL PRINT
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Cetak digital jadi lebih mudah dan menyenangkan bersama kami.
                    </p>
                    <a href="#produk"
                        class="mt-8 inline-block bg-gray-900 text-white font-bold py-3 px-8 rounded-lg hover:bg-amber-700 transition duration-300">
                        Pesan Sekarang
                    </a>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mt-8 md:mt-0 md:pl-12">
                    <img src="{{ asset('image/asset1.jpg') }}" alt="Contoh Cetakan Sidu Digital Print"
                        class="w-full h-140 object-cover rounded-lg shadow-2xl mx-auto">
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian 2: Konten Cara Menggunakan Website --}}
    <section id="cara-pemesanan" class="bg-gray-100 py-16 px-6">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">
                Cara Mudah Cetak Online di SIDU Digital Print
            </h2>
            <p class="text-gray-600 mb-12 max-w-3xl mx-auto text-center">
                Kami hadir untuk menyederhanakan proses cetak Anda. Ikuti langkah-langkah di bawah ini untuk mendapatkan
                produk cetak berkualitas.
            </p>

            {{-- Langkah-langkah dengan tampilan card yang rapi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Langkah 1: Registrasi Akun --}}
                <div
                    class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-amber-200 rounded-full flex items-center justify-center mb-4 text-amber-800">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 text-center mb-2">1. Registrasi Akun</h4>
                    <p class="text-gray-600 text-sm text-center">Daftar dengan cepat menggunakan email dan data diri Anda.
                    </p>
                </div>

                {{-- Langkah 2: Pilih Produk --}}
                <div
                    class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-200 rounded-full flex items-center justify-center mb-4 text-blue-800">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 12c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm-5-8c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0-2c-3.87 0-7 3.13-7 7s3.13 7 7 7 7-3.13 7-7-3.13-7-7-7zM2 17c0 3.87 3.13 7 7 7s7-3.13 7-7-3.13-7-7-7-7 3.13-7 7z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 text-center mb-2">2. Pilih Produk</h4>
                    <p class="text-gray-600 text-sm text-center">Telusuri berbagai produk cetak dan pilih yang sesuai
                        kebutuhan.</p>
                </div>

                {{-- Langkah 3: Unggah Desain & Sesuaikan --}}
                <div
                    class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-green-200 rounded-full flex items-center justify-center mb-4 text-green-800">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 text-center mb-2">3. Unggah Desain</h4>
                    <p class="text-gray-600 text-sm text-center">Unggah file desain Anda, lalu atur spesifikasi produk yang
                        diinginkan.</p>
                </div>

                {{-- Langkah 4: Pesan & Bayar --}}
                <div
                    class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-red-200 rounded-full flex items-center justify-center mb-4 text-red-800">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 18c-1.11 0-2 .9-2 2s.89 2 2 2 2-.9 2-2-.89-2-2-2zM7 18c-1.11 0-2 .9-2 2s.89 2 2 2 2-.9 2-2-.89-2-2-2zM7.17 14h11.97l-2.76-7H6.44l-.9 2H2.5c-.39 0-.69.31-.69.69s.31.69.69.69H4.1l1.4 4.39c.65 2.18 2.5 3.69 4.67 3.96L9.67 19H17c.28 0 .5-.22.5-.5s-.22-.5-.5-.5H9.67l-1.99-1.99L7.17 14z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 text-center mb-2">4. Pesan & Bayar</h4>
                    <p class="text-gray-600 text-sm text-center">Lakukan pemesanan dan pilih metode pembayaran yang nyaman.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian 3: Konten Tambahan --}}
    <section class="bg-white py-16 px-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-gray-50 rounded-xl shadow-md border border-gray-200">
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Proses & Produksi</h4>
                    <p class="text-gray-600 text-sm">Tim kami memproses pesanan Anda dengan cepat dan hati-hati.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl shadow-md border border-gray-200">
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pengiriman & Pelacakan</h4>
                    <p class="text-gray-600 text-sm">Kami akan menginformasikan status pesanan hingga sampai di tujuan.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl shadow-md border border-gray-200">
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pesanan Selesai</h4>
                    <p class="text-gray-600 text-sm">Pesanan sampai, nikmati produk cetak berkualitas dari kami!</p>
                </div>
            </div>
        </div>
    </section>
    {{--  @include('components.promo_section') <!--promo section--> --}}

    <!-- Product List Section -->
    {{--  <div id="produk" class="bg-white scroll-mt-16">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Produk Kami</h2>
            <p class="mt-4 text-center text-lg text-gray-600">Pilih produk berkualitas tinggi untuk semua kebutuhan cetak
                Anda.</p>

            <div class="mt-16 grid grid-cols-1 gap-y-10 gap-x-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div class="group">
                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div
                                class="flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 ease-in-out group-hover:shadow-xl group-hover:-translate-y-1.5">

                                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center transition-all duration-300 group-hover:scale-105">
                                </div>

                                <div class="flex flex-1 flex-col justify-between border-t border-gray-200 p-4">
                                    <div class="flex-1">
                                        <h3 class="text-base font-semibold text-gray-800">
                                            {{ $product->name }}
                                        </h3>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500">Mulai dari</p>
                                        <p class="text-lg font-bold text-gray-900">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}
@endsection
