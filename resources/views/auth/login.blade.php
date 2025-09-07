<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sidu Digital Print</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen block lg:flex">
        <div class="hidden lg:flex w-full lg:w-1/2 bg-gray-800 text-white p-12 flex-col justify-between">
            <div>
                <img src="{{ asset('image/logo-sidu.png') }}" alt="Sidu Digital Print Logo" class="h-12 w-auto">
            </div>
            <div class="space-y-2">
                <h1 class="text-4xl font-extrabold">Welcome to Sidu Digital Print!</h1>
                <p class="text-gray-300 max-w-md">
                    Cetak digital jadi lebih mudah dan menyenangkan bersama kami.
                </p>
            </div>
            <div>
                <img id="sliderImage" src="{{ asset('image/slide1.jpg') }}" alt="sliderImage"
                    class="rounded-lg shadow-2xl w-full h-auto">
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Selamat Datang Kembali!
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Silakan masuk ke akun Anda untuk melanjutkan
                    </p>
                </div>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

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

                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remember" value="true">
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="text" required
                                class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                placeholder="Masukkan Email Anda">
                        </div>
                        <div>
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                    placeholder="Masukkan password">
                                <div class="absolute inset-y-0 right-3 flex items-center">
                                    <button type="button" onclick="togglePassword()" class="focus:outline-none">
                                        <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.966 9.966 0 012.327-3.568M6.1 6.1l11.8 11.8M9.88 9.88a3 3 0 104.24 4.24" />
                                        </svg>
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-amber-600 hover:text-amber-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            Masuk
                        </button>
                    </div>
                </form>
                {{-- 
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-sm text-gray-400">atau lanjutkan dengan</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div>
                    <a href="#"
                        class="group relative w-full flex justify-center py-3 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <img class="w-5 h-5 mr-2" src="https://www.svgrepo.com/show/475656/google-color.svg"
                            alt="Google icon">
                        Masuk dengan Google
                    </a>
                </div>
 --}}
                <div class="text-sm text-center">
                    <p class="text-gray-600">Belum punya akun?
                        <a href="/register" class="font-medium text-amber-600 hover:text-amber-700">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const images = [
                "{{ asset('image/slide1.jpg') }}",
                "{{ asset('image/slide3.jpg') }}",
            ];
            let index = 0;
            const imgEl = document.getElementById("sliderImage");

            // Tambahkan pengecekan ini untuk menghindari error jika elemen tidak ada
            if (imgEl && images.length > 0) {
                // Set interval hanya jika elemen dan gambar tersedia
                setInterval(() => {
                    index = (index + 1) % images.length;
                    imgEl.src = images[index];
                }, 3000); // setiap 3 detik
            }
        });
    </script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

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
    </script>
    {{-- Memanggil JavaScript utama dan script tambahan melalui Vite --}}
    @vite('resources/js/app.js')
</body>

</html>
