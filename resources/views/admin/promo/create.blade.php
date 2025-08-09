@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Promo</h1>

        <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block font-semibold mb-1">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-semibold mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border rounded p-2" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                    class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block font-semibold mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                    class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block font-semibold mb-1">Gambar</label>
                <input type="file" name="image" id="image" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" class="mr-2"> Aktifkan Promo
                </label>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 transition text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
@endsection
