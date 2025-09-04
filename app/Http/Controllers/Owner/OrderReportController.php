<?php

namespace App\Http\Controllers\Owner;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class OrderReportController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan tanggal dari filter, jika tidak ada, gunakan tanggal awal dan akhir bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now());

        // Menambahkan endOfDay() pada tanggal akhir agar rentangnya mencakup seluruh hari
        $endDateWithTime = Carbon::parse($endDate)->endOfDay();
        
        // Mengambil semua pesanan dalam rentang tanggal dan memuat relasi 'pelanggan'
          $orders  = Order::with('pelanggan')
                        ->whereBetween('created_at', [$startDate, $endDateWithTime])
                        ->latest()
                        ->paginate(10); // Panggil paginate() langsung pada query builder

         
        // Menghitung metrik laporan dari koleksi pesanan yang sudah difilter
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total_price'); // Sesuaikan status
        $totalOrders = $orders->count();
        $totalCompletedOrders = $orders->where('status', 'completed')->count(); // Sesuaikan status
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Mengirim semua variabel yang dibutuhkan ke view dalam satu compact
        return view('owner.laporan.pemesanan', compact(
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
        /*  $settings = Setting::first(); // ambil setting toko */
    
    $pdf = pdf::loadView('owner.laporan.cetak-pdf', compact('orders', 'startDate', 'endDate', ''));
    return $pdf->stream('laporan-pemesanan-' . $startDate . '-sd-' . $endDate . '.pdf');

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
