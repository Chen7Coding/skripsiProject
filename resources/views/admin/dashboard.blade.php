@extends('layouts.admin')

@section('title', 'Dashboard Karyawan')

@section('admin-content')
    <div class="container mx-auto p-6 space-y-8">
        <!-- Judul -->
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                Dashboard Karyawan
            </h1>
            <p class="mt-1 text-gray-600 text-base">
                Selamat datang di panel Karyawan Sidu Digital Print.
            </p>
        </div>

        <!-- Cards Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <!-- Total Pesanan -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-amber-600 to-amber-900 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Total Pesanan</p>
                        <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
                    </div>
                    <i data-lucide="shopping-cart" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>

            <!-- Pending -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-yellow-400 to-yellow-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Pending</p>
                        <h3 class="text-2xl font-bold">{{ $totalPending }}</h3>
                    </div>
                    <i data-lucide="clock" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>

            <!-- Proses -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Proses</p>
                        <h3 class="text-2xl font-bold">{{ $totalProcessing }}</h3>
                    </div>
                    <i data-lucide="refresh-cw" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>

            <!-- Pengiriman -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-purple-500 to-pink-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Pengiriman</p>
                        <h3 class="text-2xl font-bold">{{ $totalShipping }}</h3>
                    </div>
                    <i data-lucide="truck" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>

            <!-- Selesai -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Selesai</p>
                        <h3 class="text-2xl font-bold">{{ $totalCompleted }}</h3>
                    </div>
                    <i data-lucide="check-circle" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="p-5 rounded-xl shadow-md bg-gradient-to-r from-teal-400 to-cyan-500 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium opacity-90">Total Pelanggan</p>
                        <h3 class="text-2xl font-bold">{{ $totalCustomers }}</h3>
                    </div>
                    <i data-lucide="users" class="w-6 h-6 opacity-80"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md mt-6">
            <h3 class="font-semibold mb-4 flex items-center gap-2 text-gray-800">
                <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i> Notifikasi
            </h3>
            <ul class="space-y-4">
                @forelse($notifications as $notif)
                    @php
                        $alertClasses = '';
                        $icon = '';

                        if (str_contains($notif, 'pesanan baru')) {
                            $alertClasses = 'bg-blue-50 text-blue-800 border-blue-200';
                            $icon = 'star';
                        } elseif (str_contains($notif, 'menunggu verifikasi')) {
                            $alertClasses = 'bg-yellow-50 text-yellow-800 border-yellow-200';
                            $icon = 'credit-card';
                        } elseif (str_contains($notif, 'pesanan yang sedang diproses')) {
                            $alertClasses = 'bg-purple-50 text-purple-800 border-purple-200';
                            $icon = 'refresh-cw';
                        } else {
                            $alertClasses = 'bg-gray-50 text-gray-600 border-gray-200';
                            $icon = 'info';
                        }
                    @endphp
                    <li class="flex items-start gap-4 p-3 rounded-lg border {{ $alertClasses }}">
                        <i data-lucide="{{ $icon }}" class="w-5 h-5 flex-shrink-0 mt-1"></i>
                        <p class="text-sm font-medium">{{ $notif }}</p>
                    </li>
                @empty
                    <li class="flex items-center gap-4 p-3 rounded-lg border bg-gray-50 text-gray-500">
                        <i data-lucide="bell-off" class="w-5 h-5 flex-shrink-0"></i>
                        <p class="text-sm font-medium">Tidak ada notifikasi saat ini.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="bg-white p-6 rounded-xl shadow-md mt-6">
            <h3 class="font-semibold mb-4 flex items-center gap-2">
                <i data-lucide="list" class="w-5 h-5"></i> Ringkasan Pesanan Masuk
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Invoice</th>
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestOrders as $order)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $order->order_number }}</td>
                                <td class="px-4 py-2">{{ $order->pelanggan->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $statusClasses = '';
                                        switch ($order->status) {
                                            case 'pending':
                                                $statusClasses = 'bg-yellow-100 text-yellow-600';
                                                break;
                                            case 'lunas':
                                                $statusClasses = 'bg-green-100 text-green-600';
                                                break;
                                            case 'processing':
                                                $statusClasses = 'bg-blue-100 text-blue-600';
                                                break;
                                            case 'shipping':
                                                $statusClasses = 'bg-purple-100 text-purple-600';
                                                break;
                                            case 'completed':
                                                $statusClasses = 'bg-green-100 text-green-600';
                                                break;
                                            case 'cancelled':
                                                $statusClasses = 'bg-red-100 text-red-600';
                                                break;
                                            default:
                                                $statusClasses = 'bg-gray-100 text-gray-600';
                                                break;
                                        }
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs {{ $statusClasses }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-amber-600 hover:underline">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
@endsection
