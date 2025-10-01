<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
        }

        .invoice-box {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            line-height: 1.6;
        }

        /* TABLE LAYOUTS FOR PDF COMPATIBILITY */
        .header-table, .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .header-table td, .info-table td {
            vertical-align: top;
        }

        .header-logo {
            width: 150px;
        }

        .header-logo img {
            max-width: 150px;
            height: auto;
        }

        .header-details {
            text-align: right;
            font-size: 14px;
        }
        
        .header-details .title {
            font-size: 28px;
            font-weight: bold;
            color: #8a2be2;
        }

        .info-table {
             padding-bottom: 15px;
             border-bottom: 2px solid #eee;
        }

        .info-table .column {
            width: 48%;
            font-size: 13px;
            line-height: 1.5;
        }

        /* INVOICE TABLE */
        .table-container {
            margin-top: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #eee;
            padding: 8px 10px;
            vertical-align: top;
        }

        .invoice-table th {
            background-color: #8a2be2;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .invoice-table td {
            font-size: 12px;
        }
        
        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        /* TOTAL */
        .total-section {
            margin-top: 20px;
        }

        .total-section table {
            width: 45%;
            float: right;
            border-collapse: collapse;
        }

        .total-section td {
            padding: 6px 10px;
        }
        
        .total-section tr.total-row {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        
        .logo-invoice {
            width: 100px;
        }

        /* FOOTER */
        .footer {
            margin-top: 60px;
            text-align: right;
            padding: 15px;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="invoice-box">

        <!-- HEADER -->
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <img class="logo-invoice" src="{{ public_path('logo.png') }}" alt="Logo">
                </td>
                <td class="header-details">
                    <div class="title">INVOICE</div>
                    <div>No. {{ $order->order_number }}</div>
                    <div>Tanggal: {{ $order->created_at->format('d F Y') }}</div>
                </td>
            </tr>
        </table>

        <!-- INFO -->
        <table class="info-table">
             <tr>
                <td class="column">
                    <strong>TOKO SIDU DIGITAL PRINT</strong><br>
                    Jl. Raya Majalaya - Cicalengka, Pajagalan Ruko Alsifa C3<br>
                    Telp: 0812-3456-7890<br>
                    Email: info@sidudigitalprint.com
                </td>
                <td class="column" style="text-align: left; padding-left: 200px;">
                    <strong>Kepada:</strong><br>
                    Nama: {{ $order->name }}<br>
                    Telp: {{ $order->phone }}<br>
                    Email: {{ $order->email }}<br>
                    Alamat: {{ $order->address }}
                </td>
            </tr>
        </table>

        <!-- TABLE -->
        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th class="text-left">Keterangan</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-center">Jml</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                {{ $item->product->name ?? 'Produk Dihapus' }} <br>
                                <small>Bahan: {{ $item->material ?? '-' }} | Ukuran: {{ $item->size ?? '-' }}</small>
                            </td>
                            <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item->quantity }} pcs</td>
                            <td class="text-right">
                                Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTAL -->
        <div class="total-section">
            <table>
                <tr>
                    <td>Sub Total:</td>
                    <td class="text-right">Rp{{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Kirim:</td>
                    <td class="text-right">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Tagihan:</strong></td>
                    <td class="text-right"><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <!-- FOOTER -->
        <div class="footer">
            <p style="margin-bottom: 10px; margin-right: 50px;">Mengetahui,</p>
            <p style="margin-top: 50px;">(________________________)</p>
            <p style="margin-right: 50px;">Nuki Bagja</p>
        </div>

    </div>
</body>
</html>
