@extends('layouts.owner')

@section('title', 'Dashboard Pemilik')

@section('owner-content')
    <div class="container mx-auto p-6 space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                Dashboard Pemilik
            </h1>
            <p class="mt-1 text-gray-600 text-base">
                Selamat datang di panel Pemilik Sidu Digital Print.
            </p>
        </div>

        {{-- Bagian Atas - Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <a href="#"
                class="bg-gradient-to-r from-amber-600 to-amber-900 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Total Pesanan</h4>
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalOrders }}</p>
            </a>

            <a href="#"
                class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Pending</h4>
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalPending }}</p>
            </a>

            <a href="#"
                class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Proses</h4>
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalProcessing }}</p>
            </a>

            <a href="#"
                class="bg-gradient-to-r from-purple-500 to-pink-600 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Pengiriman</h4>
                    <i data-lucide="truck" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalShipping }}</p>
            </a>

            <a href="#"
                class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Selesai</h4>
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $totalCompleted }}</p>
            </a>

            <a href="#"
                class="bg-gradient-to-r from-teal-400 to-cyan-500 text-white p-5 rounded-xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl flex flex-col">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold opacity-90">Total Pendapatan</h4>
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </a>
        </div>

        {{-- Row 1: Pie Chart + Top Produk + Top Pelanggan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Pie Chart --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <h3 class="font-semibold mb-4">📊 Distribusi Status Pesanan</h3>
                <div class="h-80">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>

            {{-- Kolom kanan (Top Produk & Top Pelanggan) --}}
            <div class="grid grid-rows-2 gap-6">
                {{-- Top Produk --}}
                <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition text-sm">
                    <h3 class="font-semibold mb-3 text-base">🛍️ Top 5 Produk Terlaris</h3>
                    <ul class="space-y-2">
                        @php $maxSold = max($topProducts->pluck('total_sold')->toArray() ?? [1]); @endphp
                        @forelse ($topProducts as $product)
                            @php $percentage = ($product->total_sold / $maxSold) * 100; @endphp
                            <li class="flex flex-col group">
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="group-hover:text-amber-600 transition">{{ $product->name }}</span>
                                    <span class="text-gray-700">{{ $product->total_sold }}x</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1 overflow-hidden">
                                    <div class="h-1.5 rounded-full bg-gradient-to-r from-amber-400 to-amber-600 transition-all duration-700 ease-out"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500 text-xs italic">Belum ada data produk</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Top Pelanggan --}}
                <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition text-sm">
                    <h3 class="font-semibold mb-3 text-base">👤 Top 5 Pelanggan Teraktif</h3>
                    <ul class="space-y-2">
                        @php $maxOrders = max($topCustomers->pluck('total_orders')->toArray() ?? [1]); @endphp
                        @forelse ($topCustomers as $customer)
                            @php $percentage = ($customer->total_orders / $maxOrders) * 100; @endphp
                            <li class="flex flex-col group">
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="group-hover:text-blue-600 transition">{{ $customer->name }}</span>
                                    <span class="text-gray-700">{{ $customer->total_orders }}x</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1 overflow-hidden">
                                    <div class="h-1.5 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 transition-all duration-700 ease-out"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500 text-xs italic">Belum ada data pelanggan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- Row 2: Line Chart (Full Width) --}}
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition mt-6">
            <h3 class="font-semibold mb-4">📈 Tren Pesanan Per Bulan</h3>
            <div class="h-80">
                <canvas id="ordersLineChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pie Chart
        new Chart(document.getElementById('ordersChart'), {
            type: 'pie',
            data: {
                labels: ['Pending', 'Proses', 'Pengiriman', 'Selesai'],
                datasets: [{
                    data: [{{ $totalPending }}, {{ $totalProcessing }}, {{ $totalShipping }},
                        {{ $totalCompleted }}
                    ],
                    backgroundColor: ['#facc15', '#6366f1', '#f97316', '#22c55e']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Line Chart
        new Chart(document.getElementById('ordersLineChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyOrdersLabels) !!},
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode($monthlyOrdersData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    {{-- Tambahin ini di layout --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
@endsection
