@extends('layouts.admin')

@section('title', 'Laporan Pemesanan')

@section('admin-content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        {{-- Header Halaman --}}
        <div class="mb-8 no-print">
            <h1 class="text-3xl font-bold text-gray-800">Laporan Pemesanan</h1>
            <p class="mt-1 text-gray-500">Pilih rentang waktu untuk melihat dan mencetak laporan.</p>
        </div>

        {{-- ============================== --}}
        {{-- ==== FILTER DAN RINGKASAN ==== --}}
        {{-- ============================== --}}
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8 no-print">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Periode</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                {{-- Total Pendapatan --}}
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-sm text-amber-700">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-amber-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                {{-- Total Pesanan --}}
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-700">Total Pesanan</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $totalOrders }}</p>
                </div>
                {{-- Pesanan Selesai --}}
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-green-700">Pesanan Selesai</p>
                    <p class="text-2xl font-bold text-green-800">{{ $totalCompletedOrders }}</p>
                </div>
                {{-- Rata-rata Nilai Pesanan --}}
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-700">Rata-rata Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Form Filter --}}
            <form action="{{ route('admin.report.admin_laporan') }}" method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                {{-- Input Tanggal --}}
                <div>
                    <label for="start_date" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date"
                        value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex space-x-2">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700">
                        Cari
                    </button>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.report.export-pdf') }}?start_date={{ $startDate }}&end_date={{ $endDate }}"
                        target="_blank"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                        PDF
                    </a>
                    <a href="{{ route('admin.report.export-csv') }}?start_date={{ $startDate }}&end_date={{ $endDate }}"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        CSV
                    </a>
                </div>
            </form>

            {{-- Input Search di tabel --}}
            <div class="mt-4">
                <input type="text" id="searchInput" placeholder="Cari data di tabel..."
                    class="w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-3 py-2">
            </div>
        </div>

        {{-- ================================= --}}
        {{-- ======== TABEL RINCIAN ======== --}}
        {{-- ================================= --}}
        <div id="print-area">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">Detail Transaksi Pesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table id="ordersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metode Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $order->user->name ?? 'Pelanggan Dihapus' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ ucfirst($order->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->payment_method ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Tidak ada data pemesanan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Script Search --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#ordersTable tbody tr");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
@endsection
