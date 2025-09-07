@extends('layouts.owner')

@section('title', 'Daftar Pesanan')

@section('owner-content')
    <div class="container mx-auto py-6">
        <h3 class="text-2xl font-bold mb-4">Daftar Pesanan</h3>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Pesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Pesanan
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- PERBAIKAN: Menambahkan array terjemahan --}}
                                    @php
                                        $statusTranslations = [
                                            'completed' => 'Pesanan Selesai',
                                            'pending' => 'Menunggu Konfirmasi',
                                            'cancelled' => 'Pesanan Batal',
                                            'processing' => 'Pesanan Diproses',
                                            'shipping' => 'Pesanan Dalam Pengiriman',
                                        ];
                                    @endphp
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                        'bg-blue-100 text-blue-800' => $order->status == 'processing',
                                        'bg-purple-100 text-purple-800' => $order->status == 'shipping',
                                        'bg-green-100 text-green-800' => $order->status == 'completed',
                                        'bg-red-100 text-red-800' => $order->status == 'cancelled',
                                    ])>
                                        {{-- Menampilkan hasil terjemahan --}}
                                        {{ $statusTranslations[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('owner.orders.show', $order->id) }}"
                                        class="text-amber-600 hover:text-amber-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data pesanan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    @endsection
