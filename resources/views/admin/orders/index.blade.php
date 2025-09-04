@extends('layouts.admin')

@section('title', 'Data Pemesanan')

@section('admin-content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Data Pemesanan</h1>
                <p class="mt-1 text-gray-500">Kelola semua pesanan yang masuk dari pelanggan.</p>
            </div>
            {{--   <a href="{{ route('admin.order_create') }}"
                class="inline-flex items-center w-full px-4 py-2 mt-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd"
                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13z"
                        clip-rule="evenodd" />
                </svg>
                Input Pesanan Offline
            </a> --}}

            {{-- Kode yang sudah diperbaiki --}}
            {{-- a href="{{ route('admin.order.create') }}"
                class="inline-flex items-center w-full px-4 py-2 mt-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-200">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd"sz
                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13z"
                        clip-rule="evenodd" />
                </svg>
                Input Pesanan Offline
            </> --}}
        </div>

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
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
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
            @if ($orders->hasPages())
                <div class="p-4 bg-gray-50 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
