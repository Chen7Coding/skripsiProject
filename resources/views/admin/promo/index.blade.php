@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Promo</h1>

        <a href="{{ route('promo.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700 transition">
            Tambah Promo
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">Judul</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promos as $promo)
                    <tr>
                        <td class="p-2 border">{{ $promo->title }}</td>
                        <td class="p-2 border">{{ $promo->start_date }} - {{ $promo->end_date }}</td>
                        <td class="p-2 border">
                            <span class="{{ $promo->is_active ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $promo->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="p-2 border">
                            <a href="{{ route('promo.edit', $promo->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            |
                            <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus promo ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Belum ada promo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
