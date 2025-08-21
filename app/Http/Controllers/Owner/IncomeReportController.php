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
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now());
        $endDateWithTime = Carbon::parse($endDate)->endOfDay();

        // Mengambil pesanan yang sudah lunas dalam rentang tanggal
        $orders = Order::where(function($query) {
            $query->where('status', 'lunas')
                  ->orWhere('status', 'completed'); // Atau status lain yang menandakan lunas
        })
        ->whereBetween('created_at', [$startDate, $endDateWithTime])
        ->get();
            
        // Menghitung total pendapatan
        $totalIncome = $orders->sum('total_price'); // Sesuaikan dengan kolom total di tabel Anda

        return view('owner.laporan.pendapatan', compact('orders', 'totalIncome', 'startDate', 'endDate'));
    }
}