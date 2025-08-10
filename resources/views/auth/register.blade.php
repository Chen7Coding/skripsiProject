<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/favicon-sidu.png') }}?v=1.0" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <title>Registrasi - Sidu Digital Print</title>

    {{-- Memanggil semua CSS dan Font melalui Vite --}}
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen block lg:flex">
        <div class="hidden lg:flex w-full lg:w-1/2 bg-gray-800 text-white p-12 flex-col justify-between">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset('image/logo-sidu.png') }}" alt="Sidu Digital Print Logo" class="h-12 w-auto">
                </a>
            </div>
            <div class="space-y-4">
                <h1 class="text-4xl font-extrabold">Satu Langkah Lagi Menuju Kemudahan Cetak</h1>
                <p class="text-gray-300 max-w-md">
                    Daftarkan akun Anda dan nikmati proses pemesanan yang cepat dan efisien.
                </p>
            </div>
            <div>
                <img src="{{ asset('image/asset_digital.jpeg') }}" alt="Contoh Produk Sidu Digital Print"
                    class="rounded-lg shadow-2xl">
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="max-w-md w-full space-y-6">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Buat Akun Baru
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Isi data di bawah untuk mendaftar.
                    </p>
                </div>

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="space-y-4" action="{{ route('register') }}" method="POST">
                    @csrf

                    {{-- Input Nama Lengkap --}}
                    <div>
                        <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap Anda</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="mt-1 appearance-none block w-full px-3 py-3 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Masukkan Nama Lengkap Anda">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Username --}}
                    <div>
                        <label for="username" class="text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" required
                            class="mt-1 appearance-none block w-full px-3 py-3 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm {{ $errors->has('username') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Masukkan Username Anda">
                        @error('username')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email"
                            value="{{ old('email') }}" required
                            class="mt-1 appearance-none block w-full px-3 py-3 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Masukkan Email Anda">
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="appearance-none block w-full px-3 py-3 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Minimal 8 karakter">
                            <div class="absolute inset-y-0 right-3 flex items-center">
                                <button type="button" data-toggle-password="password" class="focus:outline-none">
                                    <svg data-icon="eye-off" class="h-5 w-5 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.966 9.966 0 012.327-3.568M6.1 6.1l11.8 11.8M9.88 9.88a3 3 0 104.24 4.24" />
                                    </svg>
                                    <svg data-icon="eye" class="h-5 w-5 text-gray-500 hidden"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi
                            Password</label>
                        <div class="relative mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="appearance-none block w-full px-3 py-3 border placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Ulangi password di atas">
                            <div class="absolute inset-y-0 right-3 flex items-center">
                                <button type="button" data-toggle-password="password_confirmation"
                                    class="focus:outline-none">
                                    <svg data-icon="eye-off" class="h-5 w-5 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.966 9.966 0 012.327-3.568M6.1 6.1l11.8 11.8M9.88 9.88a3 3 0 104.24 4.24" />
                                    </svg>
                                    <svg data-icon="eye" class="h-5 w-5 text-gray-500 hidden"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notifikasi untuk Real-time Password Matching --}}
                    <div id="password-match-message" class="hidden mt-1 text-xs text-green-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Password cocok!</span>
                        </div>
                    </div>
                    <div id="password-mismatch-message" class="hidden mt-1 text-xs text-red-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Password tidak cocok.</span>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-200">
                            Daftar Sekarang
                        </button>
                    </div>

                    <div class="text-sm text-center">
                        <p class="text-gray-600">Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-700">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Memanggil JavaScript utama dan script tambahan --}}
    @vite('resources/js/app.js')

    {{-- JavaScript untuk halaman ini --}}
    <script>
        // Fungsi ini memastikan kode berjalan setelah seluruh halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            // --- FUNGSI UNTUK SHOW/HIDE PASSWORD ---
            function togglePasswordVisibility(button) {
                const inputId = button.dataset.togglePassword;
                const passwordInput = document.getElementById(inputId);
                if (!passwordInput) return;

                const eyeIcon = button.querySelector('[data-icon="eye"]');
                const eyeOffIcon = button.querySelector('[data-icon="eye-off"]');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                }
            }

            const toggleButtons = document.querySelectorAll('[data-toggle-password]');
            toggleButtons.forEach(button => {
                button.addEventListener('click', () => togglePasswordVisibility(button));
            });

            // --- FUNGSI UNTUK VALIDASI KECOCOKAN PASSWORD ---
            const passwordInput = document.getElementById('password');
            const confirmationInput = document.getElementById('password_confirmation');
            const matchMessage = document.getElementById('password-match-message');
            const mismatchMessage = document.getElementById('password-mismatch-message');

            function validatePasswordMatch() {
                if (!passwordInput || !confirmationInput || !matchMessage || !mismatchMessage) return;

                const passwordValue = passwordInput.value;
                const confirmationValue = confirmationInput.value;

                if (passwordValue === '' || confirmationValue === '') {
                    matchMessage.classList.add('hidden');
                    mismatchMessage.classList.add('hidden');
                    return;
                }

                if (passwordValue === confirmationValue) {
                    matchMessage.classList.remove('hidden');
                    mismatchMessage.classList.add('hidden');
                } else {
                    matchMessage.classList.add('hidden');
                    mismatchMessage.classList.remove('hidden');
                }
            }

            if (passwordInput && confirmationInput) {
                passwordInput.addEventListener('input', validatePasswordMatch);
                confirmationInput.addEventListener('input', validatePasswordMatch);
            }
        });
    </script>
</body>

</html>
