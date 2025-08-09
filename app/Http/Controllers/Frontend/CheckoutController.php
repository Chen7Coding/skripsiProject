<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Kecamatan;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $total = $subtotal;

        $kecamatans = Kecamatan::all();

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $total,
            'kecamatans' => $kecamatans
        ]);

        // Kode di bawah ini tidak akan pernah dijalankan karena ada 'return' di atas.
        // $kecamatanOptions = Kecamatan::orderBy('name')->pluck('name', 'name');
        // return view('checkout.index', compact('cartItems', 'subtotal', 'total', 'kecamatanOptions'));
    }

    /**
     * Memproses pesanan dari halaman checkout.
     */
    public function process(Request $request)
    {
        // Perbaikan: Hapus validasi untuk 'city' dan 'province' yang tidak ada di form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|string|in:Transfer Bank,Pembayaran di Tempat (COD),E-Wallet',
            'shipping_cost' => 'required|numeric|min:0',
        ]);
        
        $userCartItems = Cart::where('user_id', Auth::id())->get();
        if ($userCartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();

        try {
            // Hitung subtotal dari keranjang. Variabel ini sudah benar.
            $subtotal = $userCartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            
            // Ambil biaya pengiriman langsung dari request
            $shippingCost = $request->input('shipping_cost', 0);

            // Hitung total akhir dengan variabel yang benar
            $totalPrice = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'INV-SDP-' . strtoupper(Str::random(8)),
                'total_price' => $totalPrice, 
                'shipping_cost' => $shippingCost,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'kecamatan' => $validated['kecamatan'],
                'shipping_city' => 'Kabupaten Bandung', // Mengambil nilai statis
                'shipping_province' => 'Jawa Barat', // Mengambil nilai statis
                'shipping_postal_code' => $validated['postal_code'],
            ]);

            foreach ($userCartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'material' => $cartItem->material,
                    'size' => $cartItem->size,
                    'notes' => $cartItem->notes,
                    'design_file_path' => $cartItem->design_file_path,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            // Perbaikan: Kembalikan pesan error yang lebih spesifik untuk debugging
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function getShippingCost(Request $request)
    {
        $request->validate(['kecamatan' => 'required|string']);
        $kecamatanName = $request->input('kecamatan');
        $kecamatan = Kecamatan::where('name', $kecamatanName)->first();
        $shippingCost = $kecamatan ? $kecamatan->shipping_cost : 0;
        return response()->json(['shipping_cost' => $shippingCost]);
    }

    public function showSuccessPage($order_number)
    {
        $order = Order::with('orderItems.product')->where('order_number', $order_number)->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
