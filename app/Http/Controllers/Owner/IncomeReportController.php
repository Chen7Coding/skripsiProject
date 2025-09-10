<?php

namespace App\Http\Controllers\Owner;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IncomeReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $search    = $request->search;

        $query = Order::with('user')->whereIn('status', ['lunas', 'completed']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }

        $orders      = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalIncome = $orders->sum('total_price');

        return view('owner.laporan.pendapatan', compact('orders', 'totalIncome', 'startDate', 'endDate', 'search'));
    }

    public function exportPdf(Request $request)
{
    $startDate = $request->start_date;
    $endDate   = $request->end_date;
    $search    = $request->search;

    $query = Order::with('user')->whereIn('status', ['lunas', 'completed']);

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%$search%")
              ->orWhereHas('user', function ($uq) use ($search) {
                  $uq->where('name', 'like', "%$search%");
              });
        });
    }

    $orders      = $query->orderBy('created_at', 'desc')->get();
    $totalIncome = $orders->sum('total_price');

    $pdf = Pdf::loadView('owner.laporan.export-pdf', compact('orders', 'totalIncome', 'startDate', 'endDate'));

    return $pdf->stream('laporan-pendapatan.pdf');
}

    public function exportCsv()
{
    $fileName = 'laporan_pendapatan.csv';
    $orders = Order::with('user')->whereIn('status', ['lunas', 'completed'])->get();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['order_number', 'Tanggal', 'Customer', 'Total'];

    $callback = function() use($orders, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($orders as $row) {
            fputcsv($file, [
                $row->created_at->format('Y-m-d'),
                $row->order_number,
                $row->user->name ?? '-',
                $row->total_price
            ]);
        }
        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
}
}