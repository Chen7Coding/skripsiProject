@extends('layouts.owner')

@section('title', 'Detail Pesanan')

@section('owner-content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('owner.orders.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
            <div class="mt-2 flex items-center gap-4">
                <p class="font-semibold text-amber-600 text-lg">{{ $order->order_number }}</p>

                @php
                    $statusClasses = [
                        'completed' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'shipping' => 'bg-purple-100 text-purple-800',
                    ];
                    $statusTranslations = [
                        'completed' => 'Pesanan Selesai',
                        'pending' => 'Menunggu Konfirmasi',
                        'cancelled' => 'Pesanan Batal',
                        'processing' => 'Pesanan Diproses',
                        'shipping' => 'Pesanan Dalam Pengiriman',
                    ];
                    $defaultClasses = 'bg-gray-100 text-gray-800';
                @endphp
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses[$order->status] ?? $defaultClasses }}">
                    {{ $statusTranslations[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-500">
                {{ $order->created_at->timezone('Asia/Jakarta')->format('d F Y, H:i') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- KOLOM KIRI -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-semibold text-gray-800">Rincian Item Pesanan</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($order->orderItems as $item)
                            <li class="p-6 flex items-start space-x-6">
                                <img src="{{ asset($item->design_file_path ? 'storage/' . $item->design_file_path : 'storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name ?? 'Produk Dihapus' }}"
                                    class="h-24 w-24 rounded-md object-cover flex-shrink-0">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <dl class="mt-2 space-y-1 text-xs text-gray-500">
                                        <div>
                                            <dt class="inline font-medium">Bahan:</dt>
                                            <dd class="inline">{{ $item->material }}</dd>
                                        </div>
                                        <div>
                                            <dt class="inline font-medium">Ukuran:</dt>
                                            <dd class="inline">{{ $item->size }}</dd>
                                        </div>
                                        @if ($item->notes)
                                            <div class="mt-1">
                                                <dt class="inline font-medium">Catatan:</dt>
                                                <dd class="inline">{{ $item->notes }}</dd>
                                            </div>
                                        @endif
                                        @if ($item->design_file_path)
                                            <div class="mt-1">
                                                <dt class="inline font-medium">File Desain:</dt>
                                                <dd class="inline">
                                                    <a href="{{ asset('storage/' . $item->design_file_path) }}"
                                                        target="_blank" class="text-amber-600 hover:underline">
                                                        Lihat File
                                                    </a>
                                                    {{-- UNDuh dihapus untuk owner --}}
                                                </dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>
                                <p class="text-right font-semibold text-gray-800">
                                    Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <p class="font-bold text-gray-900">Subtotal Harga Item:</p>
                            <p class="font-bold text-gray-900">
                                Rp{{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="font-bold text-gray-900">Biaya Pengiriman:</p>
                            <p class="text-lg font-bold text-gray-900">
                                Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center border-t pt-4">
                            <p class="text-lg font-bold text-gray-800">Total Harga:</p>
                            <p class="text-lg font-bold text-gray-800">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Informasi Pengiriman -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Informasi Pengiriman</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Nama Pelanggan: {{ $order->user->name ?? 'N/A' }}</dt>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Telepon: {{ $order->user->phone ?? 'N/A' }}</dt>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email: {{ $order->user->email ?? 'N/A' }}</dt>
                        </div>
                        <div class="flex justify-between items-start">
                            <dt class="text-gray-500">Alamat: {{ $order->address }},
                                {{ $order->kecamatan }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}
                                {{ $order->shipping_postal_code }}</dt>
                        </div>
                    </dl>
                </div>

                {{-- Tampilkan bukti pembayaran (tanpa tombol verifikasi) --}}
                @if ($order->payment_status === 'paid' && $order->payment_proof_url)
                    <div class="mt-4 p-4 border border-gray-200 rounded-md bg-white shadow-md">
                        <h4 class="text-lg font-semibold text-gray-800">Bukti Pembayaran</h4>
                        <a href="{{ Storage::url($order->payment_proof_url) }}" target="_blank"
                            class="mt-3 block w-full px-4 py-2 text-center text-white bg-blue-600 rounded-lg 
               hover:bg-blue-700 transition-colors">
                            Lihat Bukti Pembayaran
                        </a>
                    </div>
                @elseif ($order->payment_status === 'unpaid')
                    <div class="mt-4 p-4 border border-gray-200 rounded-md bg-yellow-50 text-yellow-700 shadow-md">
                        <h4 class="text-md font-semibold">Belum Ada Bukti Pembayaran</h4>
                        <p>Pelanggan belum mengunggah bukti pembayaran.</p>
                    </div>
                @endif

                {{-- Bagian ubah status dihilangkan --}}
            </div>
        </div>
    </div>
@endsection
