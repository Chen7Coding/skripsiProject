@extends('layouts.admin')

@section('admin-content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Data Produk</h1>
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-4"
                role="alert"">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Produk</th>
                        <th class="px-4 py-2 border">Harga</th>
                        <th class="px-4 py-2 border">Gambar</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $product->name }}</td>
                            <td class="px-4 py-2 border">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="gambar produk" class="w-16">
                                @else
                                    <img src="{{ asset($product->image) }}" alt="gambar produk" class="w-16">
                                @endif
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-700">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
