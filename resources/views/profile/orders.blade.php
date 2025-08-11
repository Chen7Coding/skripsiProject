@extends('layouts.dashboard')

@section('title', 'Pesanan Saya')

@section('dashboard-content')
    <div class="p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pesanan Saya</h1>
        <p class="text-gray-500 mb-8">Semua pesanan yang pernah Anda buat akan ditampilkan di sini.</p>

        {{-- TEMPATKAN KODE NOTIFIKASI DI SINI --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-4" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <div x-data="{ open: false }" class="border-b border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between md:items-center p-6 hover:bg-gray-50 transition-colors duration-200 cursor-pointer"
                            @click="open = !open">
                            {{-- Info Utama Pesanan --}}
                            <div class="flex-1 mb-4 md:mb-0">
                                <div class="flex items-center gap-4">
                                    <p class="font-semibold text-amber-600 text-lg">{{ $order->order_number }}</p>
                                    {{-- Badge Status --}}
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
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $statusClasses[$order->status] ?? $defaultClasses }}">
                                        {{ $statusTranslations[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Dipesan pada: {{ $order->created_at->timezone('Asia/Jakarta')->format('d F Y, H:i') }}
                                </p>
                                {{-- Menampilkan jumlah total produk yang dipesan --}}
                                <p class="text-sm text-gray-500 mt-1">
                                    Jumlah Produk: {{ $order->orderItems->sum('quantity') }}
                                </p>
                            </div>
                            {{-- Total & Tombol Detail --}}
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="font-bold text-lg text-gray-800">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                {{-- Icon panah untuk menunjukkan bisa diperluas --}}
                                <svg x-bind:class="{ 'rotate-180': open }"
                                    class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Rincian Detail Pesanan (Tersembunyi, akan muncul saat diklik) --}}
                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="px-6 pb-6 pt-4 bg-gray-50 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Kolom Kiri: Rincian Item Pesanan --}}
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Rincian Item Pesanan</h3>
                                <ul class="space-y-4">
                                    @foreach ($order->orderItems as $item)
                                        <li class="flex items-start text-sm text-gray-700">
                                            <div
                                                class="flex-shrink-0 w-24 h-24 rounded-md overflow-hidden border border-gray-200 mr-4">
                                                <img src="{{ asset($item->design_file_path ? 'storage/' . $item->design_file_path : $item->product->image ?? 'https://placehold.co/96x96/E0E0E0/grey?text=No+Image') }}?v={{ $item->updated_at->timestamp }}"
                                                    alt="{{ $item->product->name ?? 'Produk Dihapus' }}"
                                                    class="w-full h-full object-cover object-center">
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-bold text-base text-gray-900">
                                                    {{ $item->product->name ?? 'Produk Dihapus' }}</p>
                                                <p class="text-gray-600 mt-1">{{ $item->quantity }} x
                                                    Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500">Bahan: {{ $item->material ?? '-' }},
                                                    Ukuran: {{ $item->size ?? '-' }}</p>
                                                @if ($item->notes)
                                                    <p class="text-xs text-gray-500 mt-1">Catatan:
                                                        {{ Str::limit($item->notes, 50) }}</p>
                                                @endif
                                                {{-- TAMBAHKAN KODE DI SINI: Link Lihat File Desain --}}
                                                @if ($item->design_file_path)
                                                    <a href="{{ asset('storage/' . $item->design_file_path) }}"
                                                        target="_blank"
                                                        class="mt-2 inline-flex items-center text-xs text-amber-600 hover:text-amber-700 font-medium">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        Lihat File Desain
                                                    </a>
                                                @endif

                                                {{-- Kondisional untuk menampilkan form upload hanya jika ada design_file_path --}}
                                                @if ($item->design_file_path)
                                                    <div class="mt-4">
                                                        <label class="block text-sm font-medium text-gray-900 mb-2">Pilih
                                                            File Desain Baru</label>
                                                        <form id="reupload-form"
                                                            action="{{ route('orders.reupload-design', $item->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PATCH')

                                                            <div class="flex items-center space-x-2">
                                                                <label for="reupload-input-{{ $item->id }}"
                                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-amber-200 hover:bg-amber-300 transition-colors duration-200 cursor-pointer">
                                                                    Choose File
                                                                </label>
                                                                <input type="file"
                                                                    id="reupload-input-{{ $item->id }}"
                                                                    name="new_design_file" class="hidden" required>
                                                                <span id="reupload-filename-{{ $item->id }}"
                                                                    class="text-gray-500 italic">No file chosen</span>
                                                            </div>

                                                            <button type="submit" id="submit-button-{{ $item->id }}"
                                                                class="mt-3 px-4 py-2 bg-gray-800 text-white font-medium rounded-md hover:bg-gray-900 transition-colors duration-200 hidden">
                                                                Update File
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        // Mendapatkan semua elemen label yang berperan sebagai tombol "Choose File"
                                                        const reuploadLabels = document.querySelectorAll('label[for^="reupload-input-"]');

                                                        reuploadLabels.forEach(label => {
                                                            const inputId = label.getAttribute('for');
                                                            const inputElement = document.getElementById(inputId);

                                                            if (inputElement) {
                                                                const itemId = inputId.replace('reupload-input-', '');
                                                                const filenameSpan = document.getElementById(`reupload-filename-${itemId}`);
                                                                const submitButton = document.getElementById(`submit-button-${itemId}`);

                                                                // Tambahkan event listener ke input file
                                                                inputElement.addEventListener('change', function() {
                                                                    if (this.files.length > 0) {
                                                                        filenameSpan.textContent = this.files[0].name;
                                                                        submitButton.classList.remove('hidden');
                                                                    } else {
                                                                        filenameSpan.textContent = 'No file chosen';
                                                                        submitButton.classList.add('hidden');
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    });
                                                </script>
                                        </li>
                                    @endforeach
                                </ul>


                                <div class="mt-2 pt-2 border-t border-gray-200 text-right text-lg font-bold text-gray-900">
                                    Biaya Pengiriman: Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200 text-right text-lg font-bold text-gray-900">
                                    Total Harga Item: Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </div>

                            {{-- Kolom Kanan: Informasi Pengiriman & Pembayaran --}}
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Pengiriman & Pembayaran</h3>
                                <dl class="space-y-2 text-sm text-gray-700 mt-2">
                                    <div>
                                        <dt class="font-medium">Nama Penerima: {{ $order->name }}</dt>
                                    </div>
                                    <div>
                                        <dt class="font-medium">Telepon: {{ $order->phone }}</dt>
                                    </div>
                                    <div>
                                        <dt class="font-medium">Email: {{ $order->email }}</dt>
                                    </div>
                                    <div>
                                        <dt class="font-medium">Alamat: {{ $order->address }},
                                            {{ $order->kecamatan }},{{ $order->shipping_city }},
                                            {{ $order->shipping_province }}, {{ $order->shipping_postal_code }}</dt>
                                    </div>
                                    {{--   <div class="pt-2 border-t border-gray-200 mt-2">
                                        <dt class="font-medium">Metode Pembayaran:</dt>
                                        <dd class="font-semibold text-amber-600">
                                            {{ $order->payment_method ?? 'Belum Ditentukan' }}</dd>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200 mt-2">
                                        <dt class="font-medium">Status Pembayaran:</dt>
                                        <dd class="font-semibold text-gray-700">{{ ucfirst($order->payment_status) }}</dd>
                                    </div> --}}

                                    {{-- Status Pembayaran --}}
                                    <div class="mt-4">
                                        <span class="text-sm font-medium">Status Pembayaran:</span>
                                        @if ($order->payment_status === 'unpaid')
                                            <span
                                                class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                Menunggu Pembayaran
                                            </span>
                                        @elseif ($order->payment_status === 'paid')
                                            <span
                                                class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Lunas
                                            </span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span
                                                class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                Gagal
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Kondisi jika payment_status adalah 'unpaid' --}}
                                    @if ($order->payment_status === 'unpaid')
                                        <div class="mt-6">
                                            <h3 class="text-lg font-medium text-gray-900">Unggah Bukti Pembayaran</h3>
                                            <form action="{{ route('orders.uploadPaymentProof', $order->id) }}"
                                                method="POST" enctype="multipart/form-data" class="mt-4">
                                                @csrf
                                                <input type="file" name="payment_proof" required
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 sm:text-sm">
                                                <button type="submit"
                                                    class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300">
                                                    Kirim Bukti Pembayaran
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Kondisi jika payment_status adalah 'paid' --}}
                                    @elseif ($order->payment_status === 'paid')
                                        <div class="mt-6">
                                            <h3 class="text-lg font-medium text-gray-900">Bukti Pembayaran Anda</h3>
                                            <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                                                @if ($order->payment_proof_url)
                                                    <p>Bukti pembayaran telah diunggah.</p>
                                                    <a href="{{ Storage::url($order->payment_proof_url) }}"
                                                        target="_blank"
                                                        class="text-blue-600 hover:text-blue-800 underline mt-2 inline-block">
                                                        Lihat Bukti Pembayaran
                                                    </a>
                                                    {{-- Opsi untuk ganti bukti pembayaran, bisa ditambahkan di sini --}}
                                                @else
                                                    <p>Bukti pembayaran telah dikonfirmasi, namun file tidak ditemukan.
                                                        Hubungi admin jika ada masalah.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Tombol Konfirmasi Diterima akan muncul di sini --}}
                                    @if ($order->status == 'shipping')
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <form action="{{ route('order.confirm_received', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                                    Konfirmasi Pesanan Diterima
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Tampilan jika tidak ada pesanan sama sekali --}}
                    <div class="text-center p-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda belum memiliki riwayat pesanan.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            @if ($orders->hasPages())
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
    <div x-show="showReuploadModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center"
        style="display: none;">
        <div @click.away="showReuploadModal = false"
            class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg leading-6 font-bold text-gray-900">Unggah Ulang Desain</h3>
            <p class="mt-2 text-sm text-gray-500">Pilih file baru untuk mengganti file desain Anda. File sebelumnya akan
                digantikan.</p>
            <form action="{{ route('orders.reupload-design', $order->id) }}" method="POST"
                enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf
                <input type="file" name="new_design_file" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-amber-100 file:text-amber-600 hover:file:bg-amber-200">
                <div class="flex justify-end gap-2">
                    <button type="button" @click="showReuploadModal = false"
                        class="px-4 py-2 text-sm text-gray-700 font-medium rounded-md border border-gray-300 hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm text-white font-medium rounded-md bg-amber-500 hover:bg-amber-600">Unggah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
