<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pesan Baru dari Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            padding: 20px;
            border: 1px solid #eee;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Pesan Baru dari Form Kontak</h2>
        <p><strong>Nama:</strong> {{ $nama }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>No Tlp/WA:</strong> {{ $telepon ?? 'Tidak ada' }}</p>
        <p><strong>Topik:</strong> {{ $topik }}</p>
        <hr>
        <p><strong>Isi Pesan:</strong></p>
        <p>{{ $deskripsi }}</p>

        <div class="footer">
            <p>Email ini dikirim otomatis dari {{ config('app.name') }}.</p>
        </div>
    </div>
</body>

</html>
