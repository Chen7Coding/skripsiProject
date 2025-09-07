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
        // Pastikan variabel $attributes selalu didefinisikan
        $attributes = $product->attributes()->get();
        $materials = $attributes->pluck('material')->unique();
        $sizes = $attributes->pluck('size')->unique();
        
        $cartItem = null;
        $itemIdToEdit = $request->input('edit_cart_item');

        if (Auth::check() && $itemIdToEdit) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('id', $itemIdToEdit)
                ->first();

            if ($cartItem && $cartItem->product_id != $product->id) {
                $cartItem = null;
            }
        }
        
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

            // cari modifier khusus material
            $materialAttribute = ProductAttribute::where('product_id', $product->id)
                ->where('material', $material)
                ->first();

            $modifier = $materialAttribute ? $materialAttribute->price_modifier : 0;

            // harga = harga per sqm + tambahan material
            $price = ($product->price_per_sqm * $sqm) + $modifier;

        } else {
            // Ukuran standar
            $attribute = ProductAttribute::where('product_id', $product->id)
                ->where('material', $material)
                ->where('size', $size)
                ->first();
                                
            $priceModifier = $attribute ? $attribute->price_modifier : 0;

            // Perbaiki bug: tambahkan harga dasar
            $price = $basePrice + $priceModifier;
        }
        
        // Kalikan jumlah (quantity)
        $price = $price * $quantity;

        return response()->json(['price' => $price]);
    }
}