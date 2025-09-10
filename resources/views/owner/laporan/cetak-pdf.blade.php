<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 90px;
            margin-right: 15px;
        }

        .header-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        hr {
            border: 1px solid #000;
            margin: 10px 0;
        }

        .details-container {
            margin: 10px 0 20px 0;
        }

        .details-container p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; align-items: center;">
        {{--  <div style="flex: 0 0 auto;">
            @if ($settings && $settings->store_logo)
                <img src="{{ asset('storage/' . $settings->store_logo) }}" alt="Sidu Digital Print Logo"
                    style="height:90px;">
            @endif --}}
    </div>
    <div style="flex: 1; text-align: center;">
        <h2 style="margin: 0;">TOKO SIDU DIGITAL PRINT</h2>
        <p style="margin: 0;">Jl. Pajagalan, Ruko Alsifa B2.</p>
        <p style="margin: 0;"> Desa Majalaya, Kecamatan Majalaya, Kabupaten Bandung, Jawa Barat</p>
        <p style="margin: 0;">Phone/WA: 0821-2666-3200 | Email: Nukibagja@gmail.com</p>
    </div>
    </div>

    <hr>

    <h3 style="text-align: center; margin: 10px 0;">LAPORAN DATA PEMESANAN</h3>

    <div style="text-align: right;">
        <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
    <div style="text-align: left;">
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <body>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'Pelanggan Dihapus' }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Toko Sidu Digital Print</p>
        <br><br><br>
        <p>Nuki Bagja</p>
    </div>

</html>
