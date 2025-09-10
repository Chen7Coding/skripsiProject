<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10); // bisa disesuaikan

        return view('owner.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('owner.orders.detail', compact('order'));
    }
}
