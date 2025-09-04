<footer class="bg-gray-800 text-white">
    <div class="container mx-auto py-12 px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Kolom Logo dan Deskripsi -->
            <div class="md:col-span-1">
                <img class="h-10 w-auto" src="{{ asset('storage/' . $setting->store_logo) }}"
                    alt="Sidu Digital Print Logo">SIDU
                DIGITAL PRINT
                {{-- Ganti dengan logo versi putih jika ada --}}
                <p class="text-gray-400 text-sm">
                    Solusi terpercaya untuk semua kebutuhan percetakan digital Anda di Majalaya dan sekitarnya.
                </p>
            </div>

            <!-- Kolom Link Navigasi -->
            <div>
                <h3 class="text-sm font-semibold tracking-wider uppercase">Navigasi</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Home</a></li>
                    <li><a
                            href="{{ route('frontend.promo.index') }} "class="text-gray-400 hover:text-white text-sm">Promo</a>
                    </li>
                    <li><a href="{{ route('produk') }}" class="text-gray-400 hover:text-white text-sm">Produk</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white text-sm">Tentang Kami</a>
                    </li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white text-sm">Kontak Kami</a>
                    </li>
                </ul>
            </div>

            <!-- Kolom Kontak -->
            <div>
                <h3 class="text-sm font-semibold tracking-wider uppercase">Kontak</h3>
                <ul class="mt-4 space-y-2 text-sm text-gray-400">
                    <li class="flex items-start">
                        <span class="mt-1 mr-2">&#128205;</span> <!-- Emoji Peta -->
                        <span>{{ $setting->store_address }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="mr-2">&#128222;</span> <!-- Emoji Telepon -->
                        <a href="tel:+6281234567890" class="hover:text-white">{{ $setting->store_contact }}</a>
                    </li>
                    <li class="flex items-center">
                        <span class="mr-2">&#9993;</span> <!-- Emoji Email -->
                        <a href="mailto:info@sidudigital.com" class="hover:text-white">{{ $setting->store_email }}</a>
                    </li>
                </ul>
            </div>

            <!-- Kolom Media Sosial -->
            <div>
                <h3 class="text-sm font-semibold tracking-wider uppercase">Ikuti Kami</h3>
                <div class="flex mt-4 space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm5.75-9.25a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-8 text-center">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Sidu Digital Print Majalaya. All rights
                reserved.</p>
            <p class="text-sm text-gray-500 mt-2">
                <span>Presented By Dede Achein</span>
                <span class="mx-2">&bull;</span>
                <span>STIKOM Yos Sudarso - S1 Information Systems</span>
            </p>
        </div>
</footer>
