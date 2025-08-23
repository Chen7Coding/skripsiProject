@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard Admin</h3>
    <p class="mt-2 text-gray-600">Selamat datang di panel admin Sidu Digital Print.</p>

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

    {{-- Kode panel notifikasi --}}
    <div x-data="{ open: false, lastChecked: localStorage.getItem('lastChecked') || '{{ $lastOrderTime }}', notifications: JSON.parse(localStorage.getItem('notifications')) || [] }" x-init="if (localStorage.getItem('lastChecked') === null) {
        localStorage.setItem('lastChecked', '{{ $lastOrderTime }}');
    }
    
    setInterval(() => {
        fetch(`{{ route('admin.dashboard.new-orders') }}?last_checked=${lastChecked}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.count > 0 && data.orders.length > 0) {
                    data.orders.forEach(order => {
                        if (!notifications.some(n => n.id === order.id)) {
                            notifications.unshift(order);
                        }
                    });
                    lastChecked = data.orders[0].created_at;
                    localStorage.setItem('lastChecked', lastChecked);
                    localStorage.setItem('notifications', JSON.stringify(notifications));
                    open = true;
                }
            })
            .catch(error => console.error('Error fetching new orders:', error));
    }, 10000);" class="fixed bottom-6 right-6 z-50">

        {{-- Tombol Notifikasi --}}
        <button @click="open = !open"
            class="relative bg-amber-500 text-white p-3 rounded-full shadow-lg hover:bg-amber-600 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.158 6 8.356 6 11v3.158A2.032 2.032 0 014.405 17H3m14 0a2 2 0 002 2H3a2 2 0 002-2m0 0a2 2 0 00-2-2m2 2V11a8 8 0 00-16 0v6a8 8 0 0016 0z" />
            </svg>
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
                x-show="notifications.length > 0">
                <span x-text="notifications.length"></span>
            </span>
        </button>

        {{-- Panel Notifikasi --}}
        <div x-show="open" @click.away="open = false"
            class="absolute bottom-16 right-0 w-96 max-h-96 bg-white rounded-lg shadow-xl overflow-y-auto">
            <div class="p-4 border-b">
                <h3 class="font-bold text-gray-800">Riwayat Notifikasi</h3>
            </div>
            <div id="notification-list" class="divide-y divide-gray-100">
                <template x-for="notification in notifications" :key="notification.id">
                    <div class="p-4 border-b border-gray-200 hover:bg-gray-50">
                        <p class="font-semibold text-gray-800">Pesanan Baru: <span
                                x-text="notification.order_number"></span></p>
                        <p class="text-sm text-gray-600">Dari: <span
                                x-text="notification.user ? notification.user.name : 'Pelanggan'"></span></p>
                        <p class="text-xs text-gray-400 mt-1"><span
                                x-text="new Date(notification.created_at).toLocaleString()"></span></p>
                    </div>
                </template>
                <div x-show="notifications.length === 0" class="p-4 text-center text-gray-500">Tidak ada notifikasi baru
                </div>
            </div>
        </div>
    </div>
@endsection
