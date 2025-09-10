<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders     = Order::count();
        $totalPending    = Order::where('status', 'pending')->count();
        $totalProcessing = Order::where('status', 'processing')->count();
        $totalShipping   = Order::where('status', 'shipping')->count();
        $totalCompleted  = Order::where('status', 'completed')->count();
        $totalCustomers  = User::where('role', 'pelanggan')->count();

        $latestOrders = Order::with('pelanggan')
            ->latest()
            ->take(5)
            ->get();

        
        // Perbaikan: Logika untuk notifikasi dinamis
        $notifications = [];

        // Notifikasi 1: Pesanan baru yang belum membayar (status 'pending' dan belum ada bukti)
        $newPendingOrders = Order::where('status', 'pending')
            ->whereNull('payment_proof_url')
            ->count();
        if ($newPendingOrders > 0) {
            $notifications[] = "Ada {$newPendingOrders} pesanan baru menunggu pembayaran.";
        }

        // Notifikasi 2: Pembayaran baru yang perlu diverifikasi (sudah ada bukti, status bukan 'paid')
        $unverifiedPaymentsCount = Order::whereNotNull('payment_proof_url')
            ->where('payment_status', '!=', 'paid')
            ->count();
        if ($unverifiedPaymentsCount > 0) {
            $notifications[] = "Ada {$unverifiedPaymentsCount} pesanan menunggu verifikasi pembayaran.";
        }
        

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalPending',
            'totalProcessing',
            'totalShipping',
            'totalCompleted',
            'totalCustomers',
            'latestOrders',
            'notifications'
        ));
    }
}
