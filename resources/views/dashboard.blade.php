<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p>Anda berhasil login sebagai {{ Auth::user()->role }}.</p>

        <!-- Form untuk Logout -->
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </button>
        </form>
    </div>
</body>

</html>
