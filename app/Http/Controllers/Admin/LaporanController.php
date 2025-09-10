<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    /**
     * Tampilan utama laporan pemesanan dengan filter dan statistik.
     */
    public function index(Request $request)
    {
        // 1. Ambil input tanggal dari request
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // 2. Tentukan rentang tanggal yang akan digunakan untuk query
        $query = Order::with('user');
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // 3. Ambil data pesanan dan hitung statistik
        $allOrders = (clone $query)->get();
        
        $totalOrders          = $allOrders->count();
        $completedOrders      = $allOrders->whereIn('status', ['lunas', 'completed']);
        $totalCompletedOrders = $completedOrders->count();
        $totalRevenue         = $completedOrders->sum('total_price');
        $averageOrderValue    = $totalCompletedOrders > 0 ? $totalRevenue / $totalCompletedOrders : 0;
        
        // 4. Siapkan data untuk tabel (dengan pagination)
        //    Pastikan filter tanggal dan halaman tetap ada di URL.
        $orders = (clone $query)->latest()->paginate(request('per_page', 10))->appends($request->query());

        // 5. Kirim data ke view
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
    
    /**
     * Mengambil data pesanan berdasarkan rentang tanggal untuk diekspor.
     */
    protected function getFilteredOrders(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::with('user');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }
        
        return $query->get();
    }
    
    /**
     * Ekspor laporan ke format PDF.
     */
    public function exportPdf(Request $request)
    {
        $orders = $this->getFilteredOrders($request);
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $pdf = Pdf::loadView('admin.report.export-pdf', compact('orders', 'startDate', 'endDate'));
        return $pdf->stream('laporan-pemesanan-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    /**
     * Ekspor laporan ke format CSV.
     */
    public function exportCsv(Request $request)
    {
        $orders = $this->getFilteredOrders($request);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-pemesanan-" . $startDate . "-sd-" . $endDate . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Tanggal', 'No. Pesanan', 'Pelanggan', 'Total', 'Status', 'Metode Pembayaran'));

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->created_at->format('d M Y'),
                    $order->order_number,
                    $order->user->name ?? 'Pelanggan Dihapus',
                    $order->total_price,
                    ucfirst($order->status),
                    $order->payment_method ?? '-',
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}