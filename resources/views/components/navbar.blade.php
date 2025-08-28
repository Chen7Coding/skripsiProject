<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0">
                    <img class="h-10 w-auto" src="{{ asset('storage/' . $setting->store_logo) }}"
                        alt="Sidu Digital Print Logo">
                </a>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <a href="/promo'"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Promo</a>
                        <a href="{{ route('produk') }}"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Produk</a>
                        <a href="{{ route('about') }}"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Tentang
                            Kami</a>
                        <a href="{{ route('contact') }}"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Kontak</a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-amber-600">
                            Daftar
                        </a>
                    @else
                        <div class="flex items-center ml-4 md:ml-6">
                            <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-amber-700 p-2">
                                <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.328 1.093-.826l1.821-5.464a.75.75 0 00-.67-1.036H6.098l-1.12-4.222a.75.75 0 00-.716-.542H2.25"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                @php
                                    // Panggil metode statis dari CartController untuk mendapatkan jumlah item
                                    $cartItemCount = App\Http\Controllers\Frontend\CartController::getCartCount();
                                @endphp

                                @if ($cartItemCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-amber-700 text-xs text-white font-bold">
                                        {{ $cartItemCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- Dropdown Profil -->
                            <div x-data="{ open: false }" class="relative ml-3">
                                <div>
                                    <button @click="open = !open" type="button" button @click="open = !open" type="button"
                                        class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-700 focus:ring-offset-2"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Buka menu pengguna</span>
                                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-white"
                                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                            alt="User Avatar">
                                    </button>
                                </div>
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white py-2 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1" style="display: none;">
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">
                                    </div>
                                    <!-- Bagian Header: Menampilkan info pengguna sesuai hak akses -->
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ Auth::user()->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate capitalize">
                                            {{ Auth::user()->role }}
                                        </p>
                                    </div>
                                    <!-- Bagian Dropdown Hak Akses -->
                                    <div class="py-1">
                                        @if (Auth::user()->role == 'pemilik')
                                            <a href="{{ route('owner.dashboard') }}"
                                                class="group flex w-full items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-amber-100"
                                                role="menuitem" tabindex="-1">
                                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M2.5 3A1.5 1.5 0 001 4.5v11A1.5 1.5 0 002.5 17h15a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0017.5 3h-15zM2 4.5a.5.5 0 01.5-.5h15a.5.5 0 01.5.5v2.5H2V4.5zM2 15.5V8h16v7.5a.5.5 0 01-.5.5h-15a.5.5 0 01-.5-.5z"
                                                        clip-rule="evenodd" />
                                                </svg> Dashboard Pemilik
                                            </a>
                                        @elseif (Auth::user()->role == 'karyawan')
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="group flex w-full items-center gap-3 px-4 py-2 text-sm text-gray-700  hover:bg-amber-100"
                                                role="menuitem" tabindex="-1">
                                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M2.5 3A1.5 1.5 0 001 4.5v11A1.5 1.5 0 002.5 17h15a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0017.5 3h-15zM2 4.5a.5.5 0 01.5-.5h15a.5.5 0 01.5.5v2.5H2V4.5zM2 15.5V8h16v7.5a.5.5 0 01-.5.5h-15a.5.5 0 01-.5-.5z"
                                                        clip-rule="evenodd" />
                                                </svg>Dashboard Karyawan
                                            </a>
                                        @else
                                            <a href="{{ route('profile.dashboard') }}"
                                                class="group flex w-full items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-amber-100 cursor-pointer"
                                                role="menuitem" tabindex="-1">
                                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M2.5 3A1.5 1.5 0 001 4.5v11A1.5 1.5 0 002.5 17h15a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0017.5 3h-15zM2 4.5a.5.5 0 01.5-.5h15a.5.5 0 01.5.5v2.5H2V4.5zM2 15.5V8h16v7.5a.5.5 0 01-.5.5h-15a.5.5 0 01-.5-.5z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M16.72 9.22a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 11-1.06-1.06L17.94 12l-1.22-1.22a.75.75 0 010-1.06z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M11.75 12a.75.75 0 01.75-.75h5.5a.75.75 0 010 1.5h-5.5a.75.75 0 01-.75-.75z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="group-hover:text-gray-700">Dashboard Pelanggan</span>
                                            </a>
                                        @endif
                                    </div>
                                    <!-- Bagian Keluar (dipisahkan dengan garis) -->
                                    <div class="py-1 border-t border-gray-200">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="button" onclick="confirmLogout()"
                                                class="group flex w-full items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-red-50"
                                                role="menuitem" tabindex="-1">
                                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-600"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M16.72 9.22a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 11-1.06-1.06L17.94 12l-1.22-1.22a.75.75 0 010-1.06z"
                                                        clip-rule="evenodd" />
                                                    <path fill-rule="evenodd"
                                                        d="M11.75 12a.75.75 0 01.75-.75h5.5a.75.75 0 010 1.5h-5.5a.75.75 0 01-.75-.75z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="group-hover:text-red-700 self-center">Keluar</span>
                                            </button>
                                        </form>
                                    </div>
                                    <script>
                                        // Fungsi confirmLogout bisa diletakkan di sini atau di file JS terpisah
                                        function confirmLogout() {
                                            Swal.fire({
                                                title: 'Yakin ingin keluar?',
                                                text: "Anda akan keluar dari akun Anda.",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Ya, keluar!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.querySelector('form[action="{{ route('logout') }}"]').submit();
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
</nav>
