<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Ini penting untuk keamanan request AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('image/sidu-logo-final.png') }}?v=1.0" type="image/png">

    <title>@yield('title', 'Sidu Digital Print')</title>

    {{-- MEMANGGIL TAILWIND CSS --}}
    @vite('resources/css/app.css')

    {{-- Memanggil Alpine.js (untuk dropdown, dll) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    {{-- Memasukkan Navbar --}}
    @include('components.navbar')

    <main>
        {{-- Konten utama halaman akan ada di sini --}}
        @yield('content')
    </main>

    {{-- Memasukkan Footer --}}
    @include('components.footer')

    {{-- Memanggil file JavaScript utama aplikasi --}}
    @vite('resources/js/app.js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Menyediakan "wadah" untuk script tambahan dari halaman lain --}}
    @stack('scripts')

</body>

</html>
