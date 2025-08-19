{{-- ============== BAGIAN LOGO & JUDUL ================ --}}
<div class="flex items-center justify-center py-6 mt-4">
    <div class="flex flex-col items-center">
        <img src="{{ asset('storage/' . $setting->store_logo) }}" alt="Logo" class="h-14 w-auto">
        <span class="mt-3 text-lg font-bold tracking-wider text-white">SIDU DIGITAL PRINT</span>
    </div>
</div>

{{-- ============== BAGIAN NAVIGASI MENU =============== --}}
<nav class="mt-6 px-4" x-data="{
    dataMasterOpen: {{ request()->routeIs('admin.customers.*', 'products.*', 'promo.*') ? 'true' : 'false' }},
    profileSettingsOpen: {{ request()->routeIs('admin.profile.*') ? 'true' : 'false' }}
}">

    {{-- Dashboard Karyawan --}}
    <a class="flex items-center px-4 py-3 mt-2 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-white font-bold' : '' }}"
        href="{{ route('admin.dashboard') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
        </svg>
        {{-- PERBAIKAN: Menambahkan whitespace-nowrap --}}
        <span class="mx-4 font-medium whitespace-nowrap">Dashboard Karyawan</span>
    </a>

    {{-- Dropdown Data Master --}}
    <div class="mt-2">
        <button @click="dataMasterOpen = !dataMasterOpen"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 focus:outline-none">
            <span class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                {{-- PERBAIKAN: Menambahkan whitespace-nowrap --}}
                <span class="mx-4 font-medium whitespace-nowrap">Data Master</span>
            </span>
            <span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': dataMasterOpen }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </button>

        <div x-show="dataMasterOpen" class="mt-2 ml-4 pl-4 border-l-2 border-gray-700">
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.customers.*') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('admin.customers.index') }}">Data Pelanggan</a>
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('products.*') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('admin.products.index') }}">Data Produk</a>
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('promo.*') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('promo.index') }}">Data Promo</a>
        </div>
    </div>

    {{-- Data Pemesanan --}}
    <a class="flex items-center px-4 py-3 mt-2 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500 text-white font-bold' : '' }}"
        href="{{ route('admin.orders.index') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
        </svg>
        {{-- PERBAIKAN: Menambahkan whitespace-nowrap --}}
        <span class="mx-4 font-medium whitespace-nowrap">Data Pemesanan</span>
    </a>

    {{-- Laporan Pemesanan --}}
    <a class="flex items-center px-4 py-2 mt-2 text-gray-100 transition-colors duration-200 transform rounded-md 
    {{ request()->routeIs('admin.report.admin_laporan') ? 'bg-amber-700' : 'hover:bg-amber-700' }}"
        href="{{ route('admin.report.admin_laporan') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 9.75h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5-1.5h16.5M3.75 6h16.5M3.75 18h16.5" />
        </svg>
        {{-- PERBAIKAN: Menambahkan whitespace-nowrap --}}
        <span class="mx-4 font-medium whitespace-nowrap">Laporan Pemesanan</span>
    </a>

    {{-- Dropdown Pengaturan Profil --}}
    <div class="mt-2">
        <button @click="profileSettingsOpen = !profileSettingsOpen"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-gray-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('admin.profile.*') ? 'bg-amber-500 text-white font-bold' : '' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{-- PERBAIKAN: Menambahkan whitespace-nowrap --}}
                <span class="mx-4 font-medium whitespace-nowrap">Pengaturan Profil</span>
            </span>
            <span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': profileSettingsOpen }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </button>

        <div x-show="profileSettingsOpen" class="mt-2 ml-4 pl-4 border-l-2 border-gray-700">
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.profile.edit') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('admin.profile.edit') }}">Edit Profil</a>

            {{-- Anda perlu membuat route untuk halaman ubah password, misalnya 'admin.profile.password' --}}
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.profile.password.edit') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('admin.profile.password.edit') }}">Ubah Password</a>
        </div>
    </div>
</nav>
