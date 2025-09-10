<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        // Ambil semua material & ukuran unik
        $materials = ProductAttribute::distinct()->pluck('material');
        $sizes = ProductAttribute::distinct()->pluck('size');

        return view('admin.products.create', compact('materials', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => [Rule::requiredIf($request->unit !== 'sqm'), 'nullable', 'numeric'],
            'price_per_sqm' => [Rule::requiredIf($request->unit === 'sqm'), 'nullable', 'numeric'],
            'unit'          => 'required|string|in:sqm,sheet,book',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'attributes'    => 'array',
            'attributes.*.material' => 'required|string|max:255',
            'attributes.*.size' => 'required|string|max:255',
            'attributes.*.price_modifier' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);
        
        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'description' => $validatedData['description'],
            'price' => $validatedData['price'] ?? 0,
            'price_per_sqm' => $validatedData['price_per_sqm'] ?? 0,
            'unit' => $validatedData['unit'],
            'image' => $imagePath,
        ]);

        if ($request->has('attributes')) {
            foreach ($request->attributes as $attr) {
                if (!empty($attr['material']) && !empty($attr['size'])) {
                    $product->attributes()->create([
                        'material' => $attr['material'],
                        'size' => $attr['size'],
                        'price_modifier' => $attr['price_modifier'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $materials = ProductAttribute::distinct()->pluck('material');
        $sizes = ProductAttribute::distinct()->pluck('size');
        $product->load('attributes');
        return view('admin.products.edit', compact('product', 'materials', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric',
            'unit'          => 'required|string',
            'price_per_sqm' => 'nullable|numeric',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attributes'    => 'array',
            'attributes.*.material' => 'nullable|string',
            'attributes.*.size' => 'nullable|string',
            'attributes.*.price_modifier' => 'nullable|numeric',
        ]);

        $data = $request->only(['name', 'description', 'price', 'unit', 'price_per_sqm']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->has('attributes')) {
            foreach ($request->attributes as $attr) {
                if (!empty($attr['material']) && !empty($attr['size'])) {
                    ProductAttribute::updateOrCreate(
                        ['id' => $attr['id'] ?? null, 'product_id' => $product->id],
                        ['material' => $attr['material'], 'size' => $attr['size'], 'price_modifier' => $attr['price_modifier'] ?? 0]
                    );
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
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