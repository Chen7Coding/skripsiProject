<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dasbor') - Sidu Digital Print</title>
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
                    <a href="{{ route('home') }}" class="ml-4 text-gray-600 hover:text-amber-600 font-semibold">
                        Kembali ke Toko
                    </a>
                </div>

                {{-- Kolom Kanan: Info Pengguna dan Tombol Keluar --}}
                <div class="flex items-center">
                    <span class="font-semibold mr-4">Halo Karyawan, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Keluar
                        </button>
                    </form>
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
