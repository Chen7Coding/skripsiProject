@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto py-6">

        {{-- Tambahkan di sini untuk notifikasi --}}
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <span class="font-medium">Gagal!</span> {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Kelola Promo</h1>
            <a href="{{ route('admin.promo.create') }}"
                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Tambah Promo Baru
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach ($promos as $promo)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $promo->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Berlaku: {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }} s/d
                                {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.promo.edit', $promo) }}"
                                class="text-sm text-amber-600 hover:text-amber-900 font-medium">Edit</a>
                            <form action="{{ route('admin.promo.destroy', $promo) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">Hapus</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
