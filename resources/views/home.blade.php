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


    @include('components.promo_section') <!--promo section-->

    <!-- Product List Section -->
    <div id="produk" class="bg-white scroll-mt-16">
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
    </div>
@endsection
