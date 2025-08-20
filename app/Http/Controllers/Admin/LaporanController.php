<?php

namespace App\Http\Controllers\Admin;

use view;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now());

        $endDateWithTime = Carbon::parse($endDate)->endOfDay();
        
        $orders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDateWithTime])
            ->get();
        
        // Hapus query laporan pelanggan untuk sementara
        // $laporanPelanggan = ...

        // Hitung metrik kunci dari koleksi $laporanPemesanan
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total_price');
        $totalOrders = $orders->count();
        $totalCompletedOrders = $orders->where('status', 'completed')->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Kirim semua variabel yang dibutuhkan ke view dalam satu compact
        return view('admin.report.admin_laporan', compact(
            'orders', 
            'totalRevenue', 
            'totalOrders', 
            'totalCompletedOrders', 
            'averageOrderValue', 
            'startDate', 
            'endDate'
        ));
    }
    public function exportPdf(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $orders = Order::with('user')->whereBetween('created_at', [$startDate, $endDate])->get();
    
    $pdf = PDF::loadView('admin.report.export-pdf', compact('orders', 'startDate', 'endDate'));
    return $pdf->download('laporan-pemesanan-' . $startDate . '-sd-' . $endDate . '.pdf');
}

public function exportCsv(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $orders = Order::with('user')->whereBetween('created_at', [$startDate, $endDate])->get();

    $headers = array(
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=laporan-pemesanan-" . $startDate . "-sd-" . $endDate . ".csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    );

    $callback = function() use ($orders) {
        $file = fopen('php://output', 'w');
        fputcsv($file, array('Tanggal', 'No. Pesanan', 'Pelanggan', 'Total', 'Status'));

        foreach ($orders as $order) {
            fputcsv($file, [
                $order->created_at->format('d M Y'),
                $order->order_number,
                $order->user->name ?? 'Pelanggan Dihapus',
                $order->total_price,
                ucfirst($order->status),
            ]);
        }
        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}
}