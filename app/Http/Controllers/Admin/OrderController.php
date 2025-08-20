<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan, diurutkan dari yang terbaru
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    // FUNGSI BARU: Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Memuat relasi item pesanan dan produknya
        $order->load('orderItems.product'); 
        return view('admin.orders.show', compact('order'));
    }

    // FUNGSI BARU: Memperbarui status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pesanan berhasil diperbarui.');
    }
    
    
    public function downloadDesign(OrderItem $item)
{
    
if ($item->design_file_path) {
    $path = $item->design_file_path; // contoh: 'designs/foo.pdf'

    if (Storage::disk('public')->exists($path)) {
        // Fallback universal:
        return response()->download(storage_path('app/public/'.$path));
        
        // Kalau versi kamu mendukung:
        // return Storage::disk('public')->download($path);
    }
}   
    return back()->with('error', 'File desain tidak ditemukan.');
}

     public function verifyPayment(Order $order)
    {
        // Perbarui status pembayaran menjadi 'paid'
        $order->payment_status = 'paid';
        $order->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
   
    public function createForStaff()
    {
        $products = Product::all(); // Fetch all products for the dropdown
        return view('admin.orders.create', compact('products'));
    }

    public function storeForStaff(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // 2. Create the Order
        $order = Order::create([
            'user_id' => Auth::user()->id, // This links the order to the staff member
            'order_number' => 'OFFLINE-' . time(),
            'name' => $request->name,
            'phone' => $request->phone,
            'total_price' => $request->quantity * Product::find($request->product_id)->price, // Calculate total price
            'status' => 'processing',
            'payment_status' => 'paid', // Assuming cash payment
            'notes' => $request->notes,
        ]);
        
        // 3. Create the OrderItem
        $order->orderItems()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => Product::find($request->product_id)->price,
            // You can add more item details here
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan offline berhasil dibuat!');
    }
}