<?php

namespace App\Http\Controllers\Admin;

use view;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        //Tanggal akhir agar mencakup seluruh hari
        $endDateWithTime = Carbon::parse($endDate)->endOfDay();
        // Query untuk Laporan Transaksi Pemesanan (menggunakan model Order)
        $laporanPemesanan = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDateWithTime])
            ->get();
        
        // Query untuk Laporan Data Pelanggan (menggunakan tabel users)
        $laporanPelanggan = DB::table('users')
            ->select(
                'users.name', 
                'users.email', 
                DB::raw('COUNT(orders.id) as total_pesanan'),
                DB::raw('SUM(orders.total_price) as total_pengeluaran')
            )
            ->join('orders', 'users.id', '=', 'orders.user_id') // <-- PASTIKAN foreign key-nya 'user_id'
            ->whereBetween('orders.created_at', [$startDate, $endDateWithTime])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();
            
        return view('admin.report.admin_laporan', compact('laporanPemesanan', 'laporanPelanggan', 'startDate', 'endDate')); 
    }
}