<div class="container">
    <div class="header">
        <h1>Laporan Pendapatan</h1>
        <p>Tampilan riwayat uang masuk berdasarkan periode.</p>
    </div>

    <form action="{{ route('owner.laporan.pendapatan') }}" method="GET" class="filter-form">
        Dari Tanggal: <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
        Sampai Tanggal: <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
        <button type="submit">Cari</button>
    </form>

    <div class="ringkasan-pendapatan">
        <h2>Total Pendapatan: Rp{{ number_format($totalIncome, 0, ',', '.') }}</h2>
    </div>

    <div class="detail-pemasukan">
        <h3>Detail Pemasukan</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Orderan</th>
                    <th>Uang Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $runningTotal = 0; @endphp
                @foreach ($orders as $order)
                    @php $runningTotal += $order->total; @endphp
                    <tr>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->jenis_orderan }}</td>
                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>Lunas</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
