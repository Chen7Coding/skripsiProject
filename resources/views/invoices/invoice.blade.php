<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .invoice-box {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            line-height: 1.6;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 8px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 32px;
            line-height: 32px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box .logo {
            max-width: 150px;
        }

        .header-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .footer-signature {
            margin-top: 50px;
            text-align: right;
        }

        .footer-signature p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('path/to/your/logo.png') }}" class="logo">
                            </td>
                            <td>
                                <div style="font-size: 24px; font-weight: bold; color: #8a2be2;">INVOICE</div>
                                No. {{ $order->order_number }}<br>
                                Tanggal: {{ $order->created_at->format('d F Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{-- Detail Perusahaan --}}
                                Sidu Digital Print<br>
                                Jl. Raya Majalaya - Cicalengka, Pajagalan Ruko Alsifa C3<br>
                                Telp: 0812-3456-7890<br>
                                Email: info@sidudigitalprint.com
                            </td>
                            <td>
                                {{-- Detail Pelanggan --}}
                                Kepada: {{ $order->name }}<br>
                                Telp: {{ $order->phone }}<br>
                                Email: {{ $order->email }}<br>
                                Alamat: {{ $order->address }}, {{ $order->shipping_city }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Keterangan</td>
                <td style="text-align: center;">Harga</td>
            </tr>

            @foreach ($order->orderItems as $item)
                <tr class="item">
                    <td>
                        {{ $item->product->name ?? 'Produk Dihapus' }} <br>
                        <small>
                            Bahan: {{ $item->material ?? '-' }} |
                            Ukuran: {{ $item->size ?? '-' }} |
                            Jumlah: {{ $item->quantity }} pcs
                        </small>
                    </td>
                    <td>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr class="item">
                <td>Biaya Pengiriman</td>
                <td>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>
                    Sub Total: Rp{{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}<br>
                    Total Tagihan: Rp{{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div class="footer-signature">
            <p>Mengetahui,</p>
            <p style="margin-top: 50px;">(________________________)</p>
            <p>Nuki Bagja</p>
        </div>
    </div>
</body>

</html>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .invoice-box {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            line-height: 1.6;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 8px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 32px;
            line-height: 32px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box .logo {
            max-width: 150px;
        }

        .header-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .footer-signature {
            margin-top: 50px;
            text-align: right;
        }

        .footer-signature p {
            margin: 0;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-header-title {
            font-size: 24px;
            font-weight: bold;
            color: #8a2be2;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <img src="{{ public_path('path/to/your/logo.png') }}" class="logo">
            <div>
                <div class="invoice-header-title">INVOICE</div>
                <p style="margin: 0;">No. {{ $order->order_number }}</p>
            </div>
        </div>

        <div class="invoice-details">
            <div>
                <p style="margin: 0;">Sidu Digital Print</p>
                <p style="margin: 0;">{{ $order->address }}, {{ $order->shipping_city }}</p>
                <p style="margin: 0;">Telp: {{ $order->phone }}</p>
                <p style="margin: 0;">Email: {{ $order->email }}</p>
            </div>
            <div>
                <p style="margin: 0;">Kepada: {{ $order->name }}</p>
                <p style="margin: 0;">Tanggal: {{ $order->created_at->format('d F Y') }}</p>
                <p style="margin: 0;">Status: {{ $order->status === 'paid' ? 'Lunas' : 'Belum Lunas' }}</p>
            </div>
        </div>

        <h3 class="header-title" style="background: #f0f0f0; padding: 10px;">Detail Pemesanan</h3>

        <table cellpadding="0" cellspacing="0" style="margin-top: 20px;">
            <tr class="heading" style="background-color: #8a2be2; color: white;">
                <td>Keterangan</td>
                <td style="text-align: center;">Harga</td>
                <td style="text-align: center;">Jml</td>
                <td>Total</td>
            </tr>

            @foreach ($order->orderItems as $item)
                <tr class="item">
                    <td>
                        {{ $item->product->name ?? 'Produk Dihapus' }} <br>
                        <small>
                            Bahan: {{ $item->material ?? '-' }} |
                            Ukuran: {{ $item->size ?? '-' }}
                        </small>
                    </td>
                    <td style="text-align: center;">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->quantity }} pcs</td>
                    <td>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr class="total">
                <td colspan="2" style="border-top: none;"></td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">Sub Total:</td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">
                    Rp{{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="total">
                <td colspan="2" style="border-top: none;"></td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">Biaya Kirim:</td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">
                    Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="total">
                <td colspan="2" style="border-top: none;"></td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">Total:</td>
                <td style="border-top: 2px solid #eee; font-weight: bold;">
                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 40px;">
            <p style="font-weight: bold;">Informasi Pembayaran:</p>
            <p>Metode: {{ $order->payment_method ?? 'Belum Ditentukan' }}</p>
            <p>Status: {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}</p>
        </div>

        <div class="footer-signature">
            <p>Mengetahui,</p>
            <p style="margin-top: 50px;">(________________________)</p>
            <p>Nuki Bagja</p>
        </div>
    </div>
</body>

</html>
