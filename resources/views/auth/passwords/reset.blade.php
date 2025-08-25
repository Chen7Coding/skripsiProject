@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 py-12">
        <div class="w-full max-w-lg overflow-hidden rounded-lg bg-white p-8 shadow-xl">
            <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900">Atur Ulang Password</h1>
            <p class="mt-2 text-center text-sm text-gray-600">Pastikan Anda menggunakan password yang kuat dan mudah diingat.
            </p>

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-amber-500 sm:text-sm"
                            value="{{ $email ?? old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="new-password"
                            required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-amber-500 sm:text-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            {{-- Ikon mata dengan garis coret (saat password tidak terlihat) --}}
                            <svg x-show="!show" @click="show = !show"
                                :class="{ 'text-gray-600': !show, 'text-gray-400': show }" class="h-5 w-5 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.005a3.75 3.75 0 01-5.75 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{-- Ikon mata tanpa garis (saat password terlihat) --}}
                            <svg x-show="show" @click="show = !show"
                                :class="{ 'text-gray-600': !show, 'text-gray-400': show }" class="h-5 w-5 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <div class="mt-1 relative">
                        <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'"
                            autocomplete="new-password" required
                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 pr-10 placeholder-gray-400 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-amber-500 sm:text-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            {{-- Ikon mata dengan garis coret (saat password tidak terlihat) --}}
                            <svg x-show="!show" @click="show = !show"
                                :class="{ 'text-gray-600': !show, 'text-gray-400': show }" class="h-5 w-5 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.005a3.75 3.75 0 01-5.75 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{-- Ikon mata tanpa garis (saat password terlihat) --}}
                            <svg x-show="show" @click="show = !show"
                                :class="{ 'text-gray-600': !show, 'text-gray-400': show }" class="h-5 w-5 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-amber-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
