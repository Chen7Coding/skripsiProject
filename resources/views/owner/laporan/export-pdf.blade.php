<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
            text-align: center;
        }

        .kop img {
            width: 70px;
            height: auto;
        }

        .kop-text {
            flex: 1;
        }

        .kop-text .nama-toko {
            font-size: 14px;
            font-weight: bold;
        }

        .kop-text .alamat {
            font-size: 11px;
            margin: 2px 0;
        }

        .kop-text .kontak {
            font-size: 11px;
            margin-bottom: 5px;
        }

        .line {
            border-top: 1.5px solid #000;
            margin: 8px 0 15px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #e6ffe6;
        }
    </style>
</head>

<body>
    <!-- Kop Toko -->
    <div class="kop">
        <img src="{{ public_path('image/logo.png') }}" alt="Sidu Digital Print Logo">
        <div class="kop-text">
            <div class="nama-toko">TOKO SIDU DIGITAL PRINT</div>
            <div class="alamat">Jl. Pajagalan, Ruko Alsifa B2.<br>
                Desa Majalaya, Kecamatan Majalaya, Kabupaten Bandung, Jawa Barat</div>
            <div class="kontak">Phone/WA: 0821-2666-3200 | Email: Nukibagja@gmail.com</div>
        </div>
    </div>
    <div class="line"></div>

    <!-- Judul Laporan -->
    <div class="header">
        <div class="title">Laporan Pendapatan</div>
        <div class="subtitle">
            Periode:
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : '-' }}
            s/d
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : '-' }}
        </div>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Pesanan</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th class="right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td class="right">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center">Tidak ada data</td>
                </tr>
            @endforelse
            <tr class="total">
                <td colspan="4" class="right">Total Pendapatan</td>
                <td class="right">Rp{{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
