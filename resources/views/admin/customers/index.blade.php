@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('admin-content')
    <h3 class="text-gray-800 text-3xl font-bold font-sans">Data Pelanggan</h3>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mt-4 p-4 rounded-md bg-green-500 text-white shadow-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="relative w-full md:w-1/3 mb-4 md:mb-0">
                <input type="text"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 placeholder-gray-400 font-medium"
                    placeholder="Cari pelanggan...">
                <div class="absolute top-1/2 -translate-y-1/2 left-3 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.customers.create') }}"
                class="w-full md:w-auto px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-lg transition-colors duration-200 text-center">
                Tambah Pelanggan
            </a>
        </div>

        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full shadow-sm rounded-xl overflow-hidden border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kontak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Bergabung</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->username }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->phone_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                        class="text-blue-600 hover:text-blue-900 font-semibold transition-colors duration-200">Edit</a>
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                        class="inline-block ml-4"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 font-semibold transition-colors duration-200">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $customers->links() }}
        </div>
    </div>
@endsection
