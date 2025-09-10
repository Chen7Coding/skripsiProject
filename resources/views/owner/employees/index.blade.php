@extends('layouts.owner')
@section('title', 'Data Karyawan')
@section('owner-content')
    <div class="w-full">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Data Karyawan</h1>
            <a href="{{ route('owner.employee.create') }}"
                class="px-4 py-2 bg-amber-600 text-white font-semibold rounded-md shadow hover:bg-amber-700 transition">
                Tambah Karyawan
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            {{-- Search --}}
            <div class="relative mb-4 w-1/3">
                <input type="text" id="search" value="{{ request('search') }}" placeholder="Cari karyawan..."
                    class="pl-10 pr-4 py-2 border rounded-md w-full focus:ring-amber-500 focus:border-amber-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
            </div>

            {{-- Table wrapper --}}
            <div id="employeeTable">
                @include('owner.employees.table', ['employees' => $employees])
            </div>
        </div>
    </div>

    <script>
        let timer;
        document.getElementById('search').addEventListener('keyup', function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                let query = this.value;
                fetch(`{{ route('owner.employee.index') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('employeeTable').innerHTML = data;
                    });
            }, 400);
        });
    </script>
@endsection
