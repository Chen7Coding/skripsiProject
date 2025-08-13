@extends('layouts.dashboard')

@section('title', 'Dasbor Sederhana')

@section('dashboard-content')
    <div class="p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Pelanggan</h1>
        <p class="text-gray-500 mb-8">Informasi pesanan Anda dalam satu tampilan yang ringkas.</p>

        {{-- Bagian Atas: Status Pesanan Visual & Tombol Aksi --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            {{-- Status Pesanan Visual --}}
            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md flex items-center gap-4">
                    <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 11V7a1 1 0 012 0v4a1 1 0 01-2 0zm2 4a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Menunggu Bayar</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $menungguBayarCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md flex items-center gap-4">
                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 2a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2H5zm0 2h10v2H5V4zm0 4h10v6H5V8z" />
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Dikemas - Pengiriman</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $dikemasPengirimanCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md flex items-center gap-4">
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.5-6.5a1 1 0 01-1.414 1.414L7 12a1 1 0 011.414-1.414L10 10.586l2.086-2.086a1 1 0 011.414 1.414L10 13.414l-1.5-1.5z" />
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Pesanan Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pesananSelesaiCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Tengah: Filter & Tombol Aksi --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            {{-- Filter Status Pesanan --}}
            <div class="flex gap-2">
                <button id="filter-semua"
                    class="px-4 py-2 text-sm font-medium rounded-md bg-amber-600 text-white">Semua</button>
                <button id="filter-menunggu-bayar"
                    class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-amber-300">Menunggu
                    Bayar</button>
                <button id="filter-dikemas-pengiriman"
                    class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-blue-300">Dikemas-Pengiriman</button>
                <button id="filter-selesai"
                    class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-green-300">Selesai</button>
            </div>

            {{-- Tombol Aksi Cepat --}}
            <a href="{{ route('produk') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-amber-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd"
                        d="M12.95 3.32a.5.5 0 00-.7-.03L10 5.414l-2.25-2.12a.5.5 0 10-.69.7L9.293 6H7a1 1 0 00-1 1v6a1 1 0 001 1h6a1 1 0 001-1V7a1 1 0 00-1-1h-2.293L12.95 4.02a.5.5 0 00.03-.7z"
                        clip-rule="evenodd" />
                </svg>
                Buat Pesanan Baru
            </a>
        </div>

        {{-- Bagian Bawah: Daftar Pesanan Terbaru (Cards) --}}
        <div class="space-y-4">
            @forelse ($orders as $order)
                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-start md:items-center"
                    data-status="{{ $order->status }}">
                    <div class="flex-1 mb-2 md:mb-0">
                        <p class="text-sm text-gray-500 font-semibold">Nomor Pesanan</p>
                        <p class="text-xl font-bold text-gray-800">{{ $order->order_number }}</p>
                    </div>
                    <div class="flex-1 mb-2 md:mb-0">
                        <p class="text-sm text-gray-500 font-semibold">Tanggal</p>
                        <p class="text-base text-gray-700">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex-1 mb-2 md:mb-0">
                        <p class="text-sm text-gray-500 font-semibold">Total</p>
                        <p class="text-lg font-bold text-gray-800">Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-1 text-left md:text-right">
                        <p class="text-sm text-gray-500 font-semibold mb-1">Status</p>
                        @php
                            $statusClasses = [
                                'completed' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipping' => 'bg-purple-100 text-purple-800',
                            ];
                            $statusTranslations = [
                                'completed' => 'Selesai',
                                'pending' => 'Menunggu Konfirmasi',
                                'cancelled' => 'Pesanan Batal',
                                'processing' => 'Pesanan Diproses',
                                'shipping' => 'Pesanan Dalam Pengiriman',
                            ];
                            $status = $order->status ?? 'pending';
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusTranslations[$status] ?? ucfirst($status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-white p-10 rounded-lg shadow-md text-center text-gray-500">
                    Belum ada riwayat pesanan.
                </div>
            @endforelse
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterButtons = document.querySelectorAll(".flex.gap-2 button");
            const orderCards = document.querySelectorAll("[data-status]");

            filterButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    // Hapus kelas 'aktif' dari semua tombol
                    filterButtons.forEach((btn) => {
                        btn.classList.remove("bg-amber-600", "text-white");
                        btn.classList.add("bg-gray-200", "text-gray-700");
                    });

                    // Tambahkan kelas 'aktif' ke tombol yang diklik
                    button.classList.add("bg-amber-600", "text-white");
                    button.classList.remove("bg-gray-200", "text-gray-700");

                    const filterStatus = button.id.replace("filter-", "");

                    orderCards.forEach((card) => {
                        const status = card.dataset.status;

                        if (filterStatus === "semua") {
                            card.style.display = "flex";
                        } else if (filterStatus === "dikemas-pengiriman") {
                            // Tampilkan pesanan yang sedang diproses atau dikirim
                            if (status === "diproses" || status === "dikirim" || status ===
                                "processing" || status === "shipping") {
                                card.style.display = "flex";
                            } else {
                                card.style.display = "none";
                            }
                        } else if (filterStatus === "selesai") {
                            // Tampilkan pesanan yang sudah selesai
                            if (status === "completed" || status === "selesai") {
                                card.style.display = "flex";
                            } else {
                                card.style.display = "none";
                            }
                        } else if (filterStatus === "menunggu-bayar") {
                            // Tampilkan pesanan yang menunggu pembayaran
                            if (status === "pending") {
                                card.style.display = "flex";
                            } else {
                                card.style.display = "none";
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
