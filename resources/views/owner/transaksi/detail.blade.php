@extends('layouts.owner')

@section('title', 'Detail Transaksi')

@section('owner-content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Detail Transaksi #{{ $order->order_number }}</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div>
                <h2 class="text-xl font-semibold">Informasi Pelanggan</h2>
                <p>Nama: {{ $order->user->name ?? 'N/A' }}</p>
                <p>Email: {{ $order->user->email ?? 'N/A' }}</p>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold">Detail Pesanan</h2>
                <p>Tanggal Pesanan: {{ $order->created_at->format('d M Y') }}</p>
                <p>Status: {{ ucfirst($order->status) }}</p>
                <p>Total Harga: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold">Item Pesanan</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                                Satuan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
