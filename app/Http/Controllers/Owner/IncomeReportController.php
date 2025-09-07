<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomeReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input tanggal, jika tidak ada biarkan null
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Mulai query dengan kondisi status lunas atau selesai
        $query = Order::with('user')->whereIn('status', ['lunas', 'completed']);

        // Tambahkan filter tanggal HANYA JIKA kedua input ada
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }
            
        // Ambil data pesanan dan urutkan
        $orders = (clone $query)->orderBy('created_at', 'desc')->get();
            
        // Hitung total pendapatan dari data yang sudah diambil
        $totalIncome = $orders->sum('total_price');

        // Kirim data ke view
        return view('owner.laporan.pendapatan', compact('orders', 'totalIncome', 'startDate', 'endDate'));
    }
}