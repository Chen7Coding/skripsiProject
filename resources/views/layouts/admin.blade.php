<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Sidu Digital Print</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <aside :class="sidebarOpen ? 'block' : 'hidden'"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto bg-gray-900 text-white transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 lg:block">
            @include('layouts.partials.admin-sidebar')
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Bagian Header yang sudah diperbaiki --}}
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-amber-500">
                {{-- Kolom Kiri: Tombol Sidebar dan Tautan "Kembali ke Toko" --}}
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    {{-- Tautan "Kembali ke Toko" dikembalikan ke div ini --}}
                    <a href="{{ route('home') }}"
                        class="ml-4 text-gray-600 hover:text-amber-600 font-semibold inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75V21h15V9.75" />
                        </svg>
                        <span class="hidden sm:inline">Beranda</span>
                    </a>
                </div>

                {{-- Kolom Kanan: Info Pengguna --}}
                <div class="flex items-center">
                    <span class="font-semibold mr-4">Halo Karyawan, {{ Auth::user()->name }}</span>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('admin-content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
