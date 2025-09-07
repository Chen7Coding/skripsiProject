@extends('layouts.admin')

@section('title', 'Dashboard Karyawan')

@section('admin-content')
    <div class="container mx-auto p-6 space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                Dashboard Karyawan
            </h1>
            <p class="mt-1 text-gray-600 text-base">
                Selamat datang di panel karyawan Sidu Digital Print.
            </p>
        </div>

        {{-- Ringkasan Metrik --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card: Total Pesanan Hari Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-500">Pesanan Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $orderCount }}</p>
                </div>
                <div class="p-3 bg-amber-100 text-amber-600 rounded-full">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-3 3l-3 3m0 0l3 3m-3-3h8">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Card: Pendapatan Selesai --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-500">Pendapatan Selesai</h3>
                    <p class="text-3xl font-bold text-gray-900">Rp{{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-green-100 text-green-600 rounded-full">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8a1 1 0 000 2m0 6a1 1 0 000 2">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Card: Total Pelanggan --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-500">Total Pelanggan</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $customerCount }}</p>
                </div>
                <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pesanan Terbaru --}}
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 border-b pb-4">Pesanan Terbaru</h2>
            @if ($recentOrders->isEmpty())
                <p class="mt-4 text-gray-600">Tidak ada pesanan terbaru.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-amber-600 hover:text-amber-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    {{-- Kode panel notifikasi --}}
@endsection
