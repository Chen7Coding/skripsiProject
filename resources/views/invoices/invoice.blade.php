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

        /* HEADER */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .invoice-header img {
            max-width: 150px;
            height: auto;
        }

        .invoice-header-right {
            text-align: right;
            font-size: 14px;
        }

        .invoice-header-right .title {
            font-size: 28px;
            font-weight: bold;
            color: #8a2be2;
        }

        /* INFO SECTION */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .info-section .column {
            width: 48%;
            font-size: 13px;
            line-height: 1.5;
        }

        /* TABLE */
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
            text-align: right;
        }

        .total-section table {
            width: 45%;
            float: right;
            border-collapse: collapse;
        }

        .total-section td {
            padding: 6px 10px;
        }

        .total-section tr td:first-child {
            text-align: left;
        }

        .total-section tr td:last-child {
            text-align: right;
        }

        .total-section tr:last-child {
            border-top: 2px solid #eee;
        }

        /* FOOTER */
        .footer {
            margin-top: 60px;
            text-align: right;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="invoice-box">

        <!-- HEADER -->
        <div class="invoice-header">
            <img src="{{ public_path('path/to/your/logo.png') }}" alt="Logo">
            <div class="invoice-header-right">
                <div class="title">INVOICE</div>
                <div>No. {{ $order->order_number }}</div>
                <div>Tanggal: {{ $order->created_at->format('d F Y') }}</div>
            </div>
        </div>

        <!-- INFO -->
        <div class="info-section">
            <div class="column">
                <strong>TOKO SIDU DIGITAL PRINT</strong><br>
                Jl. Raya Majalaya - Cicalengka, Pajagalan Ruko Alsifa C3<br>
                Telp: 0812-3456-7890<br>
                Email: info@sidudigitalprint.com
            </div>
            <div class="column">
                <strong>Kepada:</strong> {{ $order->name }}<br>
                Telp: {{ $order->phone }}<br>
                Email: {{ $order->email }}<br>
                Alamat: {{ $order->address }}
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th class="text-left">Keterangan</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Jml</th>
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
                            <td class="text-right">{{ $item->quantity }} pcs</td>
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
                    <td>Rp{{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Kirim:</td>
                    <td>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Total Tagihan:</strong></td>
                    <td><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Mengetahui,</p>
            <p style="margin-top: 50px;">(________________________)</p>
            <p>Nuki Bagja</p>
        </div>

    </div>
</body>

</html>
