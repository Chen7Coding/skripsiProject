<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProductAttribute;
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

        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => ['required', 'integer', 'min:1'],
            'material' => ['required', 'string'],
            'design_file_path' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:10240'],
            'size_option_type' => ['required', 'in:predefined,custom'],
            'size' => [Rule::requiredIf($request->size_option_type === 'predefined'),'nullable'],
            'custom_length' => [Rule::requiredIf($request->size_option_type === 'custom'),'nullable', 'numeric', 'min:1'],
            'custom_width' => [Rule::requiredIf($request->size_option_type === 'custom'),'nullable', 'numeric', 'min:1'],
            'notes' => ['nullable', 'string'],
        ];

        $request->validate($rules, [
            'design_file_path.mimes' => 'Format file yang Anda unggah tidak sesuai. Hanya JPG, PNG, dan JPEG yang diperbolehkan.',
        ]);

        $product = Product::find($request->product_id);

        $sizeString = null;
        $length = null;
        $width = null;
        $price = 0;

        if ($request->size_option_type === 'custom') {
            $length = $request->custom_length;
            $width = $request->custom_width;
            $sizeString = "{$length} x {$width} cm";
            $price = ($length * $width / 10000) * ($product->price_per_sqm ?? 0);
        } else {
             // Perhitungan harga untuk ukuran standar
            $sizeString = $request->size;
            $attribute = ProductAttribute::where('product_id', $product->id)
                                         ->where('material', $request->material)
                                         ->where('size', $sizeString)
                                         ->first();
            $price = $attribute->price_modifier ?? 0;
        }
        

        $designFilePath = null;
        if ($request->hasFile('design_file_path')) {
            $designFilePath = $request->file('design_file_path')->store('designs', 'public');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $price;
            $cartItem->material = $request->material;
            $cartItem->size = $sizeString;
            $cartItem->length = $length;
            $cartItem->width = $width;
            $cartItem->notes = $request->notes;
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
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $price,
                'material' => $request->material,
                'size' => $sizeString,
                'length' => $length,
                'width' => $width,
                'notes' => $request->notes,
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

    public static function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return 0;
    }

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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($itemId);
        $product = $cartItem->product;

         if ($request->has('quick_update')) {
        // Validasi sederhana
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Jumlah item berhasil diperbarui.');
    }

        // Aturan validasi khusus untuk update
        $rules = [
            'quantity' => ['required', 'integer', 'min:1'],
            'material' => ['required', 'string'],
            'size_option_type' => ['required', 'in:predefined,custom'],
            'size' => [Rule::requiredIf($request->size_option_type === 'predefined')],
            'custom_length' => [Rule::requiredIf($request->size_option_type === 'custom'), 'numeric', 'min:1'],
            'custom_width' => [Rule::requiredIf($request->size_option_type === 'custom'), 'numeric', 'min:1'],
            'notes' => ['nullable', 'string'],
            'design_file_path' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:10240'],
        ];

        $request->validate($rules, [
            'design_file_path.mimes' => 'Format file yang Anda unggah tidak sesuai. Hanya JPG, PNG, dan JPEG yang diperbolehkan.',
        ]);

        $sizeString = null;
        $length = null;
        $width = null;
        $price = 0;

        if ($request->size_option_type === 'custom') {
            $length = $request->custom_length;
            $width = $request->custom_width;
            $sizeString = "{$length} x {$width} cm";
            $price = ($length * $width / 10000) * ($product->price_per_sqm ?? 0);
        } else {
            $sizeString = $request->size;
            $basePrice = $product->price;
            $attribute = ProductAttribute::where('product_id', $product->id)
                                         ->where('material', $request->material)
                                         ->where('size', $sizeString)
                                         ->first();
            $priceModifier = $attribute ? $attribute->price_modifier : 0;
            $price = $basePrice + $priceModifier;
        }

        $designFilePath = $cartItem->design_file_path;
        if ($request->hasFile('design_file_path')) {
            if ($designFilePath) {
                Storage::delete($designFilePath);
            }
            $designFilePath = $request->file('design_file_path')->store('designs', 'public');
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $price,
            'material' => $request->material,
            'size' => $sizeString,
            'length' => $length,
            'width' => $width,
            'notes' => $request->notes,
            'design_file_path' => $designFilePath,
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }
}