@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
    <div class="bg-slate-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full space-y-8">

            <div class="bg-white shadow-xl rounded-2xl p-8 md:p-12 space-y-8">

                {{-- Bagian Header dengan Ikon --}}
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600">
                        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <h1 class="mt-5 text-3xl md:text-4xl font-extrabold text-gray-900">Pesanan Berhasil Dibuat!</h1>
                    <p class="mt-2 text-base text-gray-500">Terima kasih telah berbelanja. Pesanan Anda sedang kami
                        proses.</p>
                </div>

                {{-- Detail Utama Pesanan --}}
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-center md:text-left">
                            <p class="text-sm font-medium text-gray-500">Nomor Pesanan</p>
                            <p class="text-2xl font-bold text-amber-600 tracking-wider">
                                {{ $order->order_number }}</p>
                        </div>
                        <div class="text-center md:text-right">
                            <p class="text-sm font-medium text-gray-500">Total Tagihan</p>
                            <p class="text-3xl font-bold text-gray-800">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Rincian Pesanan & Produk --}}
                <div class="border-t border-gray-200 pt-8">
                    <dl class="space-y-6">
                        <div class="flex items-center justify-between">
                            <dt class="text-base font-medium text-gray-700">Tanggal Pesanan</dt>
                            <dd class="text-base text-gray-900">
                                {{ $order->created_at->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-base font-medium text-gray-700">Status Pesanan</dt>
                            <dd>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </dd>
                        </div>

                        {{-- Rincian Produk --}}
                        @if ($order->orderItems->count() > 0)
                            <div class="pt-6 border-t border-gray-200">
                                <dt class="text-base font-medium text-gray-700 mb-4">Rincian Produk:</dt>
                                <dd class="space-y-4">
                                    @foreach ($order->orderItems as $item)
                                        <div class="flex justify-between items-start text-sm">
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ $item->quantity }}x
                                                    {{ $item->product->name ?? 'Produk Tidak Ditemukan' }}
                                                </p>
                                                <div class="text-gray-500 mt-1 space-y-1">
                                                    @if ($item->material)
                                                        <p>Material: {{ $item->material }}</p>
                                                    @endif
                                                    @if ($item->size)
                                                        <p>Ukuran: {{ $item->size }}</p>
                                                    @endif
                                                    @if ($item->notes)
                                                        <p>Catatan: {{ $item->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="font-medium text-gray-600">
                                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Instruksi Pembayaran --}}
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-6 rounded-lg" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold">Lakukan Pembayaran</h3>
                            <div class="mt-2 text-base">
                                <p>Silakan transfer sebesar <strong
                                        class="text-xl">Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                    ke rekening berikut:</p>
                                <p class="font-semibold text-lg mt-2">BCA: 1234567890 <br> a.n. Sidu Digital Print</p>
                                <p class="mt-3">Setelah itu, mohon konfirmasi melalui WhatsApp ke <a
                                        href="https://wa.me/62812xxxxxxxx?text=Halo,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20pesanan%20nomor%20{{ $order->order_number }}"
                                        target="_blank"
                                        class="font-bold text-green-600 hover:text-green-700 underline">0812-xxxx-xxxx</a>
                                    beserta bukti transfer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row-reverse justify-center items-center gap-4 pt-6">
                    <a href="{{ route('profile.orders') }}"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                        Lihat Riwayat Pesanan Saya
                    </a>
                    <a href="{{ route('home') }}"
                        class="w-full sm:w-auto text-base font-medium text-amber-600 hover:text-amber-700">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
