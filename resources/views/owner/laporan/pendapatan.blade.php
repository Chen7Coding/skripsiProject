@extends('layouts.owner')

@section('title', 'Laporan Pendapatan')

@section('owner-content')
    <div class="container mx-auto p-6 bg-gray-100 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md">
            {{-- Header --}}
            <h1 class="text-3xl font-bold mb-2">Laporan Pendapatan</h1>
            <p class="text-gray-600 mb-6">Tampilan riwayat uang masuk berdasarkan periode.</p>

            {{-- Ringkasan Periode (Kartu) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                {{-- Total Pendapatan --}}
                <div class="bg-green-100 p-4 rounded-lg shadow-md border border-green-200">
                    <h3 class="text-lg font-semibold text-green-700">Total Pendapatan</h3>
                    <p class="text-2xl font-bold text-green-900 mt-1">Rp{{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Filter, Tombol Aksi & Pencarian --}}
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 mb-6">
                {{-- Form Filter --}}
                <form action="{{ route('owner.laporan.pendapatan') }}" method="GET"
                    class="flex flex-grow items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <label for="start_date" class="text-gray-700">Dari:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                            class="form-input rounded-md shadow-sm border-gray-300">
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="end_date" class="text-gray-700">Sampai:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                            class="form-input rounded-md shadow-sm border-gray-300">
                    </div>
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">Cari</button>
                </form>

                {{-- Kolom Pencarian --}}
                <div class="flex-grow">
                    <input type="text" placeholder="Cari data di tabel..."
                        class="form-input rounded-md shadow-sm w-full border-gray-300">
                </div>

                {{-- Tombol Ekspor --}}
                <div class="flex items-center space-x-2">
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">PDF</button>
                    <button
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">CSV</button>
                </div>
            </div>

            {{-- Tabel Detail Pemasukan --}}
            <div class="overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-inner border border-gray-200">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Detail Pemasukan</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                Orderan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uang
                                Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo
                                Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $runningTotal = 0; @endphp
                        @forelse ($orders as $order)
                            @php $runningTotal += $order->total_price; @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->jenis_orderan ?? 'Tidak Diketahui' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->status ?? 'Tidak Diketahui' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($runningTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemasukan
                                    dalam periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
