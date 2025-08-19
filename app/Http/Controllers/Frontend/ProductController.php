<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductOption;
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

        // Ambil data item dari keranjang berdasarkan rowId yang ada di URL
        $productIdToEdit = request('edit_cart_item');

        // Cek apakah ada parameter 'edit' di URL dan keranjang tidak kosong
        if (Auth::check() && $productIdToEdit) {
        
            // Cari item di keranjang database milik user yang sedang login
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('product_id', $productIdToEdit)
                            ->first();
            // Jika cartItem ditemukan, pastikan itu memang produk yang sedang dilihat
            if ($cartItem && $cartItem->product_id != $product->id) {
                $cartItem = null; // Reset jika product_id tidak cocok
            }
        }

        // 2. Logika untuk mengambil opsi produk dinamis
        $productOptions = ProductOption::where('product_id', $product->id)
                                        ->get()
                                        ->groupBy('option_type');

        // Kirim objek produk dan (jika ada) objek cartItem ke view
        return view('products.detail', compact('product', 'cartItem', "productOptions"));
    }
}