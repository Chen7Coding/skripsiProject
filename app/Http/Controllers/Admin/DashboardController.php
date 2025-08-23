<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  
    public function index()
    {
        $orderCount = Order::where('created_at', '>=', now()->subDay())->count();
        $revenue = Order::where('status', 'completed')->sum('total_price');
        $customerCount = User::count();
        $recentOrders = Order::with('user')->latest()->limit(5)->get();
        $lastOrderTime = optional($recentOrders->first())->created_at ?? Carbon::create(2000, 1, 1)->toISOString();

        return view('admin.dashboard', compact(
            'orderCount', 'revenue', 'customerCount', 'recentOrders', 'lastOrderTime'
        ));
    }

    public function checkNewOrders(Request $request)
    {
        $lastChecked = $request->get('last_checked');
        $newOrders = Order::with('user')
            ->where('created_at', '>', $lastChecked)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'count' => $newOrders->count(),
            'orders' => $newOrders,
        ]);
    }
}
