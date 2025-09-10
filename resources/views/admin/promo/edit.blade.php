@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto py-6">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 text-center mb-10">Edit Promo: {{ $promo->title }}</h1>

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-8 space-y-6">

            {{-- Tambahkan di sini untuk notifikasi error validasi --}}
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium">Terjadi kesalahan!</span> Silakan periksa kembali input Anda.
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.promo.update', $promo) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Bagian Input Promo --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Promo</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $promo->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" name="image" id="image"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                            accept="image/*">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @if ($promo->image)
                            <p class="text-sm text-gray-500 mt-2">Gambar saat ini: <img
                                    src="{{ asset('storage/' . $promo->image) }}" class="w-32 mt-1 rounded-md"></p>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $promo->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bagian Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ old('start_date', \Carbon\Carbon::parse($promo->start_date)->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            required>
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', \Carbon\Carbon::parse($promo->end_date)->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            required>
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Status Promo</label>
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="mt-1 h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500"
                        {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                    <p class="text-xs text-gray-500">Centang untuk mengaktifkan promo.</p>
                    @error('is_active')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="w-full rounded-md border border-transparent bg-amber-600 py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors duration-200">
                        Perbarui Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
