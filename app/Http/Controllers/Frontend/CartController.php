<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login untuk melihat keranjang Anda.');
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $total = $subtotal;
        return view('cart.index', compact('cartItems', 'subtotal', 'total'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
            'notes' => 'nullable|string',
            'design_file_path' => 'nullable|file|mimes:jpg,png,pdf,cdr,psd|max:10240',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $designFilePath = null;
        if ($request->hasFile('design_file_path')) {
            $designFilePath = $request->file('design_file_path')->store('designs','public');
        }

        $product = Product::find($productId);

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->material = $request->input('material');
            $cartItem->size = $request->input('size');
            $cartItem->notes = $request->input('notes');
            if ($designFilePath) {
                if ($cartItem->design_file_path) {
                    Storage::delete($cartItem->design_file_path);
                }
                $cartItem->design_file_path = $designFilePath;
            }
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
                'material' => $request->input('material'),
                'size' => $request->input('size'),
                'notes' => $request->input('notes'),
                'design_file_path' => $designFilePath,
            ]);
        }
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menghapus item dari keranjang.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return back()->with('error', 'Item keranjang tidak ditemukan.');
    }

    /**
     * Metode untuk mendapatkan jumlah item di keranjang (misal untuk navbar).
     * Ini adalah metode yang hilang dan menyebabkan error.
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return 0;
    }

    /**
     * Metode untuk mendapatkan total harga keranjang.
     */
    public static function getCartTotal()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            return $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
        }
        return 0;
    }

   public function update(Request $request, $itemId)
{
    // Pastikan pengguna sudah login
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Cari item keranjang berdasarkan ID dan user_id
    $cartItem = Cart::where('user_id', Auth::id())
                     ->find($itemId);

    if (!$cartItem) {
        return back()->with('error', 'Item keranjang tidak ditemukan.');
    }

    $request->validate([
        'quantity' => 'required|integer|min:1',
        'material' => 'nullable|string',
        'size' => 'nullable|string',
        'notes' => 'nullable|string',
        'design_file_path' => 'nullable|file|mimes:jpg,png,pdf,cdr,psd|max:10240',
    ]);

    $cartItem->quantity = $request->input('quantity');
    $cartItem->material = $request->input('material');
    $cartItem->size = $request->input('size');
    $cartItem->notes = $request->input('notes');

    if ($request->hasFile('design_file_path')) {
        if ($cartItem->design_file_path) {
            Storage::delete($cartItem->design_file_path);
        }
        $cartItem->design_file_path = $request->file('design_file_path')->store('designs', 'public');
    }

    $cartItem->save();
    
    return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
}
}