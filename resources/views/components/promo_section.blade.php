@extends('layouts.app')

@section('content')
    @if ($promos->count() > 0)
        <div id="promo" class="bg-gray-900 scroll-mt-16">
            <div class="container mx-auto max-w-7xl px-6 py-16 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($promos as $promo)
                        <div class="overflow-hidden rounded-lg bg-white shadow-2xl">
                            <img class="w-full h-48 object-cover" src="{{ asset($promo->image) }}" alt="{{ $promo->title }}">
                            <div class="p-6">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-amber-700">Promo Spesial</h2>
                                <p class="mt-2 text-xl font-extrabold text-gray-900">{{ $promo->title }}</p>
                                <p class="mt-2 text-gray-600">{{ $promo->description }}</p>
                                <p class="mt-2 text-sm font-medium text-gray-500">
                                    Berlaku sampai: {{ \Carbon\Carbon::parse($promo->end_date)->format('d F Y') }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('produk') }}"
                                        class="inline-block rounded-md bg-gray-900 py-2 px-6 text-center font-medium text-white hover:bg-amber-700">
                                        Belanja Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-gray-600">Tidak ada promo aktif saat ini.</p>
    @endif
@endsection
