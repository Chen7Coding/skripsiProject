@extends('layouts.app')

@section('title', 'Promo Kami')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <h1 class="text-4xl font-bold text-gray-900 text-center mb-10">Promo yang Sedang Berlangsung</h1>

        @if ($promos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($promos as $promo)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $promo->title }}</h2>
                            <p class="mt-2 text-gray-600">{{ $promo->description }}</p>
                            <div class="mt-4 text-sm text-gray-500">
                                Berlaku hingga: {{ \Carbon\Carbon::parse($promo->end_date)->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-lg">Saat ini tidak ada promo yang tersedia.</p>
        @endif
    </div>
@endsection
