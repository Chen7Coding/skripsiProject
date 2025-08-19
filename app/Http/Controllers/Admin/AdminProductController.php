<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::oldest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price']);
        $slug = Str::slug($request->name);
    
        $originalSlug = $slug;
        $count = 2;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
    }
    $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product=Product::create($data);

        return redirect()->route('products.store', $product->slug)->with('success', 'Produk berhasil ditambahkan. Silakan tambahkan opsi produk.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
         $productOptions = ProductOption::where('product_id', $product->id)
                                            ->get()
                                            ->groupBy('option_type');
        return view('admin.products.edit', compact('product','productOptions'));
    }

      public function storeOptions(Request $request, Product $product)
{
    $request->validate([
        'option_type' => 'required|string|in:material,size,finishing',
        'value' => 'required|string|max:255',
        'price_modifier' => 'nullable|numeric|min:0',
    ]);

    $product->productOptions()->create([
        'option_type' => $request->option_type,
        'value' => $request->value,
        'price_modifier' => $request->price_modifier ?? 0,
    ]);

    return back()->with('success', 'Opsi produk berhasil ditambahkan.');
}

public function destroyOptions(ProductOption $option)
{
    $option->delete();

    return back()->with('success', 'Opsi produk berhasil dihapus.');
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}