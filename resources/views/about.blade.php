@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-white">
    <!-- Bagian Header -->
    <div class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900">Kisah di Balik Setiap Cetakan</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
            Lebih dari sekadar percetakan, kami adalah partner kreatif Anda di Majalaya.
        </p>
    </div>

    <!-- Bagian Utama: Gambar dan Teks -->
    <!-- Bagian Utama: Gambar dan Teks -->
    <div class="container mx-auto px-6 pb-16">
        <div class="flex flex-wrap items-start -mx-4">
            <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                <img src="{{ asset('image/asset1.jpg') }}" alt="Toko Sidu Digital Print" class="rounded-lg shadow-2xl w-full h-auto object-cover">
            </div>
            <div class="w-full md:w-1/2 px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Sidu Digital Print</h2>
                <p class="text-gray-600 mb-6">
                    Sidu Digital Print adalah solusi terpercaya untuk semua kebutuhan percetakan digital Anda di Majalaya dan sekitarnya. Sejak berdiri pada tahun 2020, kami berkomitmen untuk memberikan kualitas cetak terbaik dengan pelayanan yang cepat, ramah, dan harga yang kompetitif.
                </p>
                <p class="text-gray-600">
                    Kami percaya bahwa setiap cetakan memiliki cerita, dan kami bangga menjadi bagian dari cerita sukses para pelanggan kami, mulai dari pelaku usaha kecil hingga perusahaan besar.
                </p>
            </div>
        </div>
    </div>

    <!-- Bagian Keunggulan Kami -->
    <div class="bg-gray-50">
        <div class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Kenapa Memilih Kami?</h2>
                <p class="mt-4 text-lg text-gray-600">Komitmen kami untuk kepuasan Anda.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white mx-auto">
                        <!-- Ikon Kualitas -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900">Kualitas Terbaik</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Kami menggunakan mesin dan bahan baku terbaik untuk hasil cetak yang tajam dan tahan lama.
                    </p>
                </div>
                <div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white mx-auto">
                        <!-- Ikon Kecepatan -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900">Pelayanan Cepat</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Kami menghargai waktu Anda. Proses pemesanan yang mudah dan pengerjaan yang efisien.
                    </p>
                </div>
                <div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-amber-500 text-white mx-auto">
                        <!-- Ikon Harga -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900">Harga Kompetitif</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Dapatkan penawaran harga terbaik tanpa mengorbankan kualitas hasil cetakan Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
