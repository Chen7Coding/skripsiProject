<?php 

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Ringkasan atas ---
        $totalOrders     = Order::count();
        $totalPending    = Order::where('status', 'pending')->count();
        $totalProcessing = Order::where('status', 'processing')->count();
        $totalShipping   = Order::where('status', 'shipping')->count();
        $totalCompleted  = Order::where('status', 'completed')->count();
        $totalRevenue    = Order::where('status', 'completed')->sum('total_price');

        // --- Grafik Bulanan ---
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyOrdersLabels = $monthlyOrders->map(fn($item) =>
            Carbon::create()->month($item->month)->translatedFormat('F')
        )->toArray();

        $monthlyOrdersData = $monthlyOrders->pluck('total')->toArray();

         // --- Top Produk ---
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // --- Top Pelanggan ---
        $topCustomers = User::select('users.id', 'users.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_orders')
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'totalOrders',
            'totalPending',
            'totalProcessing',
            'totalShipping',
            'totalCompleted',
            'totalRevenue',
            'monthlyOrdersLabels',
            'monthlyOrdersData',
            'topProducts',
            'topCustomers'
        ));
    }
}
