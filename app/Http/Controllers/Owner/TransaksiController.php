<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua transaksi untuk pemilik.
     */
    public function index(Request $request)
    {
        // Mengambil semua transaksi dengan relasi user (pelanggan)
        $orders = Order::with('user')->latest()->get();
        
        return view('owner.transaksi.index', compact('orders'));
    }

    public function show($id)
    {
        // Temukan transaksi berdasarkan ID, dan muat relasi yang diperlukan
        $order = Order::with('user', 'items')->findOrFail($id);

        return view('owner.transaksi.detail', compact('order'));
    }
}
