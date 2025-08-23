<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman detail produk.
     * Sekarang juga menangani mode "Edit".
     */
    public function show(Request $request, Product $product)
    {
        // PERUBAHAN 2: Logika untuk menangani mode edit
       $cartItem = null;

    $itemIdToEdit = request('edit_cart_item'); // Ganti nama variabel agar lebih jelas

    if (Auth::check() && $itemIdToEdit) {
    
        // PERBAIKAN DI SINI: Cari berdasarkan ID item keranjang, bukan ID produk.
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('id', $itemIdToEdit) // Perbaikan utama
                        ->first();
                        
        if ($cartItem && $cartItem->product_id != $product->id) {
            $cartItem = null;
        }
    }

    return view('products.detail', compact('product', 'cartItem'));
    }
}