@extends('layouts.owner')

@section('title', 'Laporan Pendapatan')

@section('owner-content')
    <div class="container mx-auto p-6 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md">
            {{-- Header --}}
            <h1 class="text-3xl font-bold mb-2">Laporan Pendapatan</h1>
            <p class="text-gray-600 mb-6">Tampilan riwayat uang masuk berdasarkan periode.</p>

            {{-- Ringkasan Total Pendapatan --}}
            <div class="bg-green-100 p-4 rounded-lg shadow-md border border-green-200 mb-6">
                <h3 class="text-lg font-semibold text-green-700">Total Pendapatan</h3>
                <p class="text-2xl font-bold text-green-900 mt-1">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>

            {{-- Filter, Tombol Aksi & Pencarian --}}
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 mb-6">
                {{-- Form Filter --}}
                <form action="{{ route('owner.laporan.pendapatan') }}" method="GET"
                    class="flex flex-grow items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <label for="start_date" class="text-gray-700">Dari:</label>
                        {{-- Nilai input dipertahankan setelah filter --}}
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                            class="form-input rounded-md shadow-sm border-gray-300">
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="end_date" class="text-gray-700">Sampai:</label>
                        {{-- Nilai input dipertahankan setelah filter --}}
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                            class="form-input rounded-md shadow-sm border-gray-300">
                    </div>
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">Cari</button>
                </form>

                {{-- Kolom Pencarian & Tombol Ekspor --}}
                <div class="flex items-center space-x-4 md:ml-auto">
                    <input type="text" placeholder="Cari data di tabel..."
                        class="form-input rounded-md shadow-sm border-gray-300 w-full md:w-auto">
                    <a href="{{ route('owner.laporan.pendapatan.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                        target="_blank"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">
                        PDF
                    </a>
                    <a href="{{ route('owner.laporan.pendapatan.export-csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                        CSV
                    </a>
                </div>
            </div>

            {{-- Tabel Rincian Pesanan --}}
            <div class="mt-8 overflow-x-auto rounded-lg shadow-md">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor
                                Pesanan</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="py-3 px-6 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $order->order_number }}</td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i:s') }}</td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->user->name ?? 'Pelanggan Tidak Dikenal' }}</td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm">
                                    {{-- Tambahkan logika warna label status --}}
                                    @php
                                        $statusClass = '';
                                        if ($order->status === 'completed' || $order->status === 'lunas') {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } elseif ($order->status === 'cancelled') {
                                            $statusClass = 'bg-red-100 text-red-800';
                                        } else {
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                        }
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                    Tidak ada data pesanan yang lunas pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
