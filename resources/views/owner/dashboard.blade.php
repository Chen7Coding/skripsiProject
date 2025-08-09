@extends('layouts.owner')

@section('title', 'Dashbiard Pemilik')

@section('owner-content')
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard Pemilik</h3>
    <p class="mt-2 text-gray-600">Ringkasan data penjualan, pelanggan, dan produk.</p>

    <!-- Kartu Statistik -->
    <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Total Pelanggan</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">150</p>
        </div>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Total Pemesanan (Bulan Ini)</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">75</p>
        </div>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Produk Terjual (Bulan Ini)</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">240</p>
        </div>
    </div>
@endsection
