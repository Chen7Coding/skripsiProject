<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelanggan') - Sidu Digital Print</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <aside :class="sidebarOpen ? 'block' : 'hidden'"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto bg-gray-900 text-white transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 lg:block">

            {{-- Logo Perusahaan --}}
            <div class="flex items-center justify-center py-6 mt-4">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('storage/' . $setting->store_logo) }}" alt="Logo" class="h-14 w-auto">
                    <span class="mt-3 text-lg font-bold tracking-wider text-white">SIDU DIGITAL PRINT</span>
                </div>
            </div>

            {{-- Menu Navigasi --}}
            <nav class="mt-6 px-4" x-data="{
                openOrders: {{ request()->routeIs('profile.orders*') ? 'true' : 'false' }},
                openProfile: {{ request()->routeIs('profile.edit*') || request()->routeIs('profile.password.*') ? 'true' : 'false' }}
            }">
                {{-- Link Dashboard --}}
                <a class="flex items-center px-4 py-3 mt-2 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 {{ request()->routeIs('profile.dashboard') ? 'bg-amber-500 text-white font-bold' : '' }}"
                    href="{{ route('profile.dashboard') }}">
                    <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                    </svg>
                    <span class="mx-4 font-medium whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Dropdown Pesanan --}}
                <div class="mt-2">
                    <button @click="openOrders = !openOrders"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('profile.orders*') ? 'bg-amber-500 text-white font-bold' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            <span class="mx-4 font-medium whitespace-nowrap">Pesanan Saya</span>
                        </span>
                        <span>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': openOrders }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                    <div x-show="openOrders" class="mt-2 ml-4 pl-4 border-l-2 border-gray-700">
                        <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('profile.orders') ? 'text-amber-400 font-semibold' : '' }}"
                            href="{{ route('profile.orders') }}">Riwayat Pesanan</a>
                    </div>
                    <!--<div x-show="openOrders" class="mt-2 ml-4 pl-4 border-l-2 border-gray-700">
                        <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white
                            href="">Riwayat Pesanan</a>
                    </div>-->
                </div>

                {{-- Dropdown Pengaturan Profil --}}
                <div class="mt-2">
                    <button @click="openProfile = !openProfile"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('profile.edit*') || request()->routeIs('profile.password.*') ? 'bg-amber-500 text-white font-bold' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="mx-4 font-medium whitespace-nowrap">Pengaturan Profil</span>
                        </span>
                        <span>
                            <svg class="w-4 h-4 transition-transform duration-300"
                                :class="{ 'rotate-180': openProfile }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                    <div x-show="openProfile" class="mt-2 ml-4 pl-4 border-l-2 border-gray-700">
                        <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('profile.edit') ? 'text-amber-400 font-semibold' : '' }}"
                            href="{{ route('profile.edit') }}">Edit Profil</a>
                        <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('profile.password.edit') ? 'text-amber-400 font-semibold' : '' }}"
                            href="{{ route('profile.password.edit') }}">Ubah Password</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- =================================================== -->
        <!-- ============== KONTEN UTAMA (DIPERBARUI) ========== -->
        <!-- =================================================== -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-amber-500">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <a href="{{ route('home') }}" class="ml-4 text-gray-600 hover:text-amber-600 font-semibold">Kembali
                        ke Toko</a>
                </div>
                <div class="flex items-center">
                    <span class="font-semibold mr-4">Halo, {{ Auth::user()->name }}</span>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('dashboard-content')
                </div>
            </main>
        </div>
    </div>

    {{-- Link library Alpine.js dengan atribut 'defer' --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

    {{-- Link file JavaScript Anda dengan atribut 'defer' --}}
    {{-- <script src="{{ asset('js/dashboard_plg.js') }}" defer></script> --}}
</body>

</html>
