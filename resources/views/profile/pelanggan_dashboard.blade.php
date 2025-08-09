@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <h3 class="text-gray-700 text-3xl font-medium">Dasbor Ringkasan</h3>

    <!-- Kartu Statistik -->
    <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Total Pesanan</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">12</p>
            <p class="mt-1 text-sm text-gray-500">+5% dari bulan lalu</p>
        </div>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Pesanan Diproses</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">3</p>
            <p class="mt-1 text-sm text-gray-500">Menunggu konfirmasi</p>
        </div>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Pesanan Dikirim</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">1</p>
            <p class="mt-1 text-sm text-gray-500">Sedang dalam perjalanan</p>
        </div>
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-sm font-medium text-gray-600 uppercase">Pesanan Selesai</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900">8</p>
            <p class="mt-1 text-sm text-gray-500">Telah diterima</p>
        </div>
    </div>

    <!-- Tabel Pesanan Terakhir -->
    <div class="mt-8">
        <h4 class="text-gray-700 text-xl font-medium">Pesanan Terakhir</h4>
        <div class="flex flex-col mt-6">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    No. Pesanan</th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">INV-12345</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">28 Juli 2025</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">Rp75.000</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">INV-12344</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">27 Juli 2025</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">Rp50.000</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dikirim</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
