<div class="flex items-center justify-center py-6 mt-4">
    <div class="flex flex-col items-center">
        <img src="{{ asset('storage/' . $setting->store_logo) }}" alt="Logo" class="h-14 w-auto">
        <span class="mt-3 text-lg font-bold tracking-wider text-white">SIDU DIGITAL PRINT</span>
    </div>
</div>

<nav class="mt-6 px-4" x-data="{
    openTransaksi: {{ request()->routeIs('owner.transactions.*') ? 'true' : 'false' }},
    openProfile: {{ request()->routeIs('owner.profile.*') ? 'true' : 'false' }}
}">

    <a class="flex items-center px-4 py-3 mt-2 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 {{ request()->routeIs('owner.dashboard') ? 'bg-amber-500 text-white font-bold' : 'text-gray-300' }}"
        href="{{ route('owner.dashboard') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
        </svg>
        <span class="mx-4 font-medium whitespace-nowrap">Dashboard</span>
    </a>

    <a class="flex items-center px-4 py-3 mt-2 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 {{ request()->routeIs('owner.employee.*') ? 'bg-amber-500 text-white font-bold' : 'text-gray-300' }}"
        href="{{ route('owner.employee.index') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.003A6.375 6.375 0 0112 22.5c-2.998 0-5.74-1.1-7.819-2.907M15 19.128a9.336 9.336 0 00-3.428-.744M12 22.5a8.966 8.966 0 01-5.982-2.275M12 22.5c-2.998 0-5.74-1.1-7.819-2.907M12 15a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="mx-4 font-medium whitespace-nowrap">Data Karyawan</span>
    </a>

    <div class="mt-2">
        <button @click="openTransaksi = !openTransaksi"
            class="flex items-center justify-between w-full px-4 py-3 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('owner.transactions.*') ? 'bg-amber-500 text-white font-bold' : 'text-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                <span class="mx-4 font-medium whitespace-nowrap">Transaksi</span>
            </span>
            <span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': openTransaksi }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </button>
        <div x-show="openTransaksi" class="mt-2 ml-4 pl-4 border-l-2 border-slate-700" style="display: none;">
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.transactions.index') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('owner.transaksi.index') }}">Lihat Transaksi</a>
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.transactions.status') ? 'text-amber-400 font-semibold' : '' }}"
                href="#">Status Pembayaran</a>
        </div>
    </div>

    <div x-data="{ openLaporan: false }" class="mt-2">
        <button @click="openLaporan = !openLaporan"
            class="flex items-center justify-between w-full px-4 py-3 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('owner.transactions.*') ? 'bg-amber-500 text-white font-bold' : 'text-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 9.75h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5-1.5h16.5M3.75 6h16.5" />
                </svg>
                <span class="mx-4 font-medium whitespace-nowrap">Laporan</span>
            </span>
            <span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': openLaporan }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </button>
        <div x-show="openLaporan" class="mt-2 ml-4 pl-4 border-l-2 border-slate-700" style="display: none;">
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.transactions.index') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('owner.laporan.pemesanan') }}"> Laporan Pemesanan </a>
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.transactions.status') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('owner.laporan.pendapatan') }}"> Laporan Pendapatan </a>
        </div>
    </div>

    <div class="mt-2">
        <button @click="openProfile = !openProfile"
            class="flex items-center justify-between w-full px-4 py-3 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 focus:outline-none {{ request()->routeIs('owner.profile.*') ? 'bg-amber-500 text-white font-bold' : 'text-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="mx-4 font-medium whitespace-nowrap">Pengaturan Profil</span>
            </span>
            <span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': openProfile }"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </button>
        <div x-show="openProfile" class="mt-2 ml-4 pl-4 border-l-2 border-slate-700" style="display: none;">
            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.profile.edit') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('owner.profile.edit') }}">Edit Profil</a>

            <a class="block py-2 px-4 text-sm rounded-lg text-gray-400 hover:bg-slate-800 hover:text-white {{ request()->routeIs('owner.profile.password.edit') ? 'text-amber-400 font-semibold' : '' }}"
                href="{{ route('owner.profile.password.edit') }}">Ubah Password</a>
        </div>
    </div>

    <a class="flex items-center px-4 py-3 mt-2 text-gray-300 transition-colors duration-300 transform rounded-lg hover:bg-slate-800 hover:text-gray-100 {{ request()->routeIs('owner.settings.index') ? 'bg-amber-500 text-white font-bold' : '' }}"
        href="{{ route('owner.settings.index') }}">
        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="mx-4 font-medium whitespace-nowrap">Pengaturan Toko</span>
    </a>
</nav>
