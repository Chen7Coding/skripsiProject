<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman detail produk.
     * Menggunakan Route Model Binding untuk Product.
     */
    public function show(Request $request, Product $product)
    {
        // 1. Ambil semua opsi bahan dan ukuran untuk produk ini.
        // Logika ini harus selalu ada di luar kondisi `if` agar variabel selalu tersedia.
         $attributes = $product->attributes()->get();

    $materials = $attributes->pluck('material')->unique();
    $sizes = $attributes->pluck('size')->unique();
        
        // 2. Logika untuk mode "Edit" keranjang.
        $cartItem = null;
        $itemIdToEdit = $request->input('edit_cart_item');

        if (Auth::check() && $itemIdToEdit) {
            // Cari item keranjang berdasarkan ID item dan pastikan milik pengguna yang login.
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('id', $itemIdToEdit)
                            ->first();

            // Cek apakah item keranjang yang akan diedit sesuai dengan produk yang sedang dilihat.
            if ($cartItem && $cartItem->product_id != $product->id) {
                $cartItem = null; // Abaikan jika tidak cocok.
            }
        }
        
        // 3. Kembalikan view dengan data yang diperlukan.
        // Pastikan nama view sudah benar: 'products.detail'
        return view('products.detail', compact('product', 'cartItem', 'materials', 'sizes', 'attributes'));
    }

    /**
     * Method untuk mendapatkan harga berdasarkan atribut produk.
     */
    public function getPrice(Product $product, Request $request)
    {
        $material = $request->get('material');
        $size = $request->get('size');
        $length = $request->get('length'); // cm
        $width  = $request->get('width');  // cm
        $quantity = $request->get('quantity', 1);
        
        $basePrice = $product->price;
        $price = 0;

         // Kalau custom size
    if ($length && $width) {
        // hitung luas dalam m2
        $sqm = ($length / 100) * ($width / 100);

        // cari modifier khusus material (misalnya Flexi Korea lebih mahal dari Flexi China)
        $materialAttribute = ProductAttribute::where('product_id', $product->id)
            ->where('material', $material)
            ->first();

        $modifier = $materialAttribute ? $materialAttribute->price_modifier : 0;

        // harga = harga per sqm dasar + tambahan material
        $price = ($product->price_per_sqm * $sqm) + $modifier;
    } else{
        
        $attribute = ProductAttribute::where('product_id', $product->id)
                                     ->where('material', $material)
                                     ->where('size', $size)
                                     ->first();
                                     
        $priceModifier = $attribute ? $attribute->price_modifier : 0;
        $price = $basePrice + $priceModifier;
    }
         // Kalikan jumlah (quantity)
    $price = $price * $quantity;
        return response()->json(['price' => $price]);
    }
}