<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil metrik penting
        $orderCount = Order::where('created_at', '>=', now()->subDay())->count();
        $revenue = Order::where('status', 'completed')->sum('total_price');
        $customerCount = User::count();

        // Ambil pesanan terbaru (contoh: 5 pesanan)
        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(5)
                             ->get();

        return view('admin.dashboard', compact('orderCount', 'revenue', 'customerCount', 'recentOrders'));
    }
}
