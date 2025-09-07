{{-- @extends('layouts.admin')

@section('title', 'Input Pesanan Offline')

@section('admin-content')
    <div class="p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Input Pesanan Offline</h1>
        <p class="text-gray-500 mb-8">Formulir cepat untuk mencatat pesanan dari pelanggan di toko.</p>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-xl">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Data Pelanggan</h3>
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" name="customer_name" id="customer_name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <hr>

                    <h3 class="text-lg font-semibold text-gray-900">Detail Pesanan</h3>
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                        <select name="product_id" id="product_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <hr>

                    <button type="submit"
                        class="w-full px-4 py-2 bg-gray-900 text-white font-medium rounded-md hover:bg-amber-700">
                        Simpan Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
 --}}
