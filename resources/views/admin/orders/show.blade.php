@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('admin-content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>

        {{-- =================================================== --}}
        {{-- ============== HEADER HALAMAN (DIPERBAIKI) ======== --}}
        {{-- =================================================== --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
            <div class="mt-2 flex items-center gap-4">
                <p class="font-semibold text-amber-600 text-lg">{{ $order->order_number }}</p>

                {{-- PERBAIKAN: Kode status badge yang lebih rapi dan dengan terjemahan --}}
                @php
                    // Kunci array tetap dalam Bahasa Inggris (sesuai data di database)
                    $statusClasses = [
                        'completed' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'shipping' => 'bg-purple-100 text-purple-800',
                    ];
                    // Array untuk menerjemahkan status ke Bahasa Indonesia
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
            <!-- KOLOM KIRI: RINCIAN ITEM -->
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
                                                    <span class="mx-1 text-gray-400">|</span>
                                                    <a href="{{ route('admin.orders.download-design', $item->id) }}"
                                                        class="text-amber-900 hover:underline">
                                                        Unduh File
                                                    </a>
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

            <!-- KOLOM KANAN: INFO & AKSI -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Informasi Pengiriman -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Informasi Pengiriman</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Nama Pelanggan: {{ $order->name }}</dt>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Telepon: {{ $order->phone }}</dt>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email: {{ $order->email }}</dt>
                        </div>
                        <div class="flex justify-between items-start">
                            <dt class="text-gray-500">Alamat: {{ $order->address }},
                                {{ $order->kecamatan }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}
                                {{ $order->shipping_postal_code }}</dt>
                        </div>
                    </dl>
                </div>

                {{-- Cek apakah order memiliki bukti pembayaran dan statusnya 'paid' --}}
                @if ($order->payment_status === 'paid' && $order->payment_proof_url)
                    <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-800">Bukti Pembayaran</h4>
                        <p class="mt-2">Pelanggan telah mengunggah bukti pembayaran, perlu diverifikasi.</p>
                        <a href="{{ Storage::url($order->payment_proof_url) }}" target="_blank"
                            class="mt-2 inline-block px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Lihat Bukti Pembayaran
                        </a>
                    </div>

                    {{-- Tombol Verifikasi Pembayaran hanya muncul jika belum diverifikasi --}}
                    <div class="mt-4">
                        <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                                Verifikasi Pembayaran
                            </button>
                        </form>
                    </div>
                @elseif ($order->payment_status === 'unpaid')
                    {{-- Jika bukti pembayaran belum ada --}}
                    <div class="mt-4 p-4 border border-gray-200 rounded-md bg-yellow-50 text-yellow-700">
                        <h4 class="text-md font-semibold">Belum Ada Bukti Pembayaran</h4>
                        <p>Pelanggan belum mengunggah bukti pembayaran.</p>
                    </div>
                @endif

                <!-- Ubah Status Pesanan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ubah Status Pesanan</h3>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-2">
                            <div class="flex-grow">
                                <label for="status" class="sr-only">Status Pesanan</label>
                                <select name="status" id="status"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                    {{-- Value tetap dalam Bahasa Inggris --}}
                                    <option value="pending" @if ($order->status == 'pending') selected @endif>Menunggu
                                        Konfirmasi</option>
                                    <option value="processing" @if ($order->status == 'processing') selected @endif>Pesanan
                                        Diproses</option>
                                    <option value="shipping" @if ($order->status == 'shipping') selected @endif>Pesanan Dalam
                                        Pengiriman</option>
                                    <option value="completed" @if ($order->status == 'completed') selected @endif>Pesanan
                                        Selesai</option>
                                    <option value="cancelled" @if ($order->status == 'cancelled') selected @endif>Pesanan
                                        Batal</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="flex-shrink-0 rounded-md border border-transparent bg-amber-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
