@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
<div class="bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Header -->
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kontak Kami</h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">Ada yang bisa kami bantu? Kami menerima pesan kritik dan saran Anda. Silakan hubungi kami.</p>
        </div>

        <!-- Form Kontak -->
        <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            @csrf
            <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Nama</label>
                    <div class="mt-2.5">
                        <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan Nama">
                    </div>
                </div>
                <div>
                    <label for="topic" class="block text-sm font-semibold leading-6 text-gray-900">Topik Pesan</label>
                    <div class="mt-2.5">
                        <input type="text" name="topic" id="topic" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan Topik">
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
                    <div class="mt-2.5">
                        <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan Email">
                    </div>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold leading-6 text-gray-900">No Tlp/WA</label>
                    <div class="mt-2.5">
                        <input type="tel" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Masukkan No Tlp/WA">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Detail Deskripsi</label>
                    <div class="mt-2.5">
                        <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Deskripsi"></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                {{-- Kelas focus-visible:outline telah dihapus untuk menghilangkan warning --}}
                <button type="submit" class="block w-full rounded-md bg-gray-900 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Kirim Pesan</button>
            </div>
        </form>

        <!-- Peta Lokasi -->
        <div class="mt-16">
            <div class="mx-auto max-w-4xl">
                <h3 class="text-xl font-semibold text-center text-gray-900 mb-4">Lokasi Kami</h3>
                <div class="aspect-w-16 aspect-h-9 rounded-lg shadow-xl overflow-hidden">
                    <!-- Ganti dengan kode embed Google Maps Anda -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.6676317055244!2d107.76353669999999!3d-7.0482867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c0d52a6c633b%3A0x4ab8b55a388b6f6b!2sPUSAT%20PERCETAKAN_SIDU%20DIGITAL%20PRINTING_MAJALAYA!5e0!3m2!1sid!2sid!4v1753322445538!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection