@extends('layouts.admin')

@section('title', 'Laporan Pemesanan')

@section('admin-content')

    {{-- x-data dan x-init untuk inisialisasi Alpine.js dari data controller --}}
    <div class="container mx-auto p-4 sm:p-6 lg:p-8" x-data="dateFilter()" x-init="startDate = '{{ $startDate }}';
    endDate = '{{ $endDate }}'">

        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 no-print">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Laporan Pemesanan</h1>
                <p class="mt-1 text-gray-500">Pilih rentang waktu untuk melihat dan mencetak laporan.</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm mb-8 no-print">
            {{-- Arahkan action form ke route yang sudah dibuat --}}
            <form action="{{ route('admin.report.admin_laporan') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                {{-- Filter Tanggal Cepat --}}
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="text-sm font-medium text-gray-700">Pilih Periode Cepat</label>
                    <div class="mt-1 flex space-x-2">
                        <button type="button" @click="setToday(); $event.target.closest('form').submit();"
                            class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">Hari
                            Ini</button>
                        <button type="button" @click="setThisWeek(); $event.target.closest('form').submit();"
                            class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">Minggu
                            Ini</button>
                        <button type="button" @click="setThisMonth(); $event.target.closest('form').submit();"
                            class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">Bulan
                            Ini</button>
                    </div>
                </div>

                {{-- Filter Rentang Tanggal --}}
                <div>
                    <label for="start_date" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" x-model="startDate"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" x-model="endDate"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex space-x-2">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700">
                        Cari
                    </button>
                    <button type="button" @click="printReport()"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Cetak
                    </button>
                </div>
            </form>
        </div>

        <div id="print-area">
            {{-- Header Laporan (muncul saat dicetak) --}}
            <div class="hidden print:block mb-8 text-center">
                <h2 class="text-2xl font-bold">Laporan Pemesanan</h2>
                <p>Periode: <span
                        x-text="formatDate(startDate)">{{ \Carbon\Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    s/d <span
                        x-text="formatDate(endDate)">{{ \Carbon\Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                </p>
                <p class="mt-1 text-sm">Sidu Digital Print</p>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">Laporan Transaksi Pemesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Mengisi data dari controller secara dinamis --}}
                            @forelse ($laporanPemesanan as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Tidak ada data pemesanan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">Laporan Data Pelanggan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Mengisi data dari controller secara dinamis --}}
                            @forelse ($laporanPelanggan as $pelanggan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{ $pelanggan->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pelanggan->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $pelanggan->total_pesanan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        Rp{{ number_format($pelanggan->total_pengeluaran, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Tidak ada data pelanggan yang melakukan pemesanan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function dateFilter() {
            return {
                startDate: '',
                endDate: '',

                setToday() {
                    const today = new Date();
                    this.startDate = today.toISOString().slice(0, 10);
                    this.endDate = today.toISOString().slice(0, 10);
                    document.querySelector('form').submit();
                },
                setThisWeek() {
                    const today = new Date();
                    // Dapatkan nomor hari (0=Minggu, 1=Senin, dst)
                    const day = today.getDay() || 7;

                    // Hitung tanggal untuk hari Senin
                    const firstDayOfWeek = new Date(today.setDate(today.getDate() - day + 1));

                    // Hitung tanggal untuk hari Sabtu (5 hari setelah Senin)
                    const lastDayOfWeek = new Date(firstDayOfWeek);
                    lastDayOfWeek.setDate(lastDayOfWeek.getDate() + 5);

                    this.startDate = firstDayOfWeek.toISOString().slice(0, 10);
                    this.endDate = lastDayOfWeek.toISOString().slice(0, 10);
                    document.querySelector('form').submit();
                },
                setThisMonth() {
                    const today = new Date();
                    const y = today.getFullYear();
                    const m = today.getMonth();

                    // MENGATUR TANGGAL MULAI MENJADI TANGGAL 1 DI BULAN INI
                    this.startDate = new Date(y, m, 1).toISOString().slice(0, 10);
                    console.log('Nilai Tanggal Mulai yang Dihasilkan:', calculatedStartDate);
                    // MENGATUR TANGGAL AKHIR MENJADI TANGGAL HARI INI
                    this.endDate = today.toISOString().slice(0, 10);

                    document.querySelector('form').submit();
                },
                formatDate(dateString) {
                    if (!dateString) return '...';
                    const date = new Date(dateString + 'T00:00:00Z');
                    const options = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };
                    return date.toLocaleDateString('id-ID', options);
                },
                printReport() {
                    window.print();
                }
            }
        }
    </script>
@endsection
