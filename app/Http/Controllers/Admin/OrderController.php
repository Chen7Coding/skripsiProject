<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Helpers\WhatsAppHelper;
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

          // Simpan status lama sebelum diperbarui
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        $order->update(['status' => $request->status]);

         // Kirim notifikasi jika status berubah
        if ($oldStatus != $newStatus) {
            $order->load('user'); // Muat relasi user untuk mendapatkan nomor pelanggan

            // Ambil nomor pemilik dari pengaturan
            $ownerSettings = Setting::first();
            $ownerNumber = $ownerSettings->owner_whatsapp_number ?? null;
            
            // Ambil nomor pelanggan dari order
            $customerNumber = $order->user->whatsapp_number ?? null;

            // Pesan untuk pemilik
            $ownerMessage =  "🔔 *Pembaruan Status Pesanan!* 🔔\n\n"
                      . "Nomor Pesanan: *#{$order->order_number}*\n"
                      . "Status Baru: *{$newStatus}*\n"
                      . "Pelanggan: {$order->user->name}\n"
                      . "Total: Rp " . number_format($order->total_price, 0, ',', '.') . "\n\n";
             if ($ownerNumber) {
            WhatsAppHelper::sendNotification($ownerNumber, $ownerMessage);
            }
            // Pesan untuk pelanggan
            $customerMessage = "🛍️ *Sidu Digital Print*\n\n"
             . "Halo, {$order->user->name}!\n\n"
             . "Status pesanan Anda *#{$order->order_number}* telah diperbarui menjadi *{$newStatus}*.\n\n"
             . "Terima kasih telah berbelanja bersama kami! 🙏";
             if ($customerNumber) {
            WhatsAppHelper::sendNotification($customerNumber, $customerMessage);
        }
    }
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
        // Cek dulu, kalau statusnya sudah lunas (paid), jangan lakukan apa-apa.
        // Ini mencegah verifikasi berulang.
        if ($order->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Pembayaran sudah diverifikasi.');
        }

        // Perbarui status pembayaran menjadi 'paid'
        $order->payment_status = 'paid';

        // Perbarui status pesanan utama menjadi 'processing' atau 'diproses'
        // Ini menandakan pesanan sudah bisa dikerjakan.
        $order->status = 'processing'; 

        $order->save();

        // Berikan pesan sukses yang lebih informatif
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi. Pesanan dilanjutkan ke tahap proses.');
    }
   
   /*  public function createForStaff()
    {
        $products = Product::all(); // Fetch all products for the dropdown
        return view('admin.orders.create', compact('products'));
    } */

   /*  public function storeForStaff(Request $request)
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
    } */
}