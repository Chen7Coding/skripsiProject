<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan, diurutkan dari yang terbaru
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    // FUNGSI BARU: Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Memuat relasi item pesanan dan produknya
        $order->load('orderItems.product'); 
        return view('admin.orders.show', compact('order'));
    }

    // FUNGSI BARU: Memperbarui status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
