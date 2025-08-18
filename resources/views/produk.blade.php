@extends('layouts.app')
@section('content')
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
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="aspect-w-1 aspect-1 h-full w-full object-cover object-center transition-all duration-300 group-hover:scale-105">
                                    @else
                                    @endif

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
