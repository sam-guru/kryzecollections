<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',

            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',

            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'sizes' => $request->sizes,
            'colors' => $request->colors,
            'affiliate_url' => $request->affiliate_url,
            'is_affiliate' => $request->boolean('is_affiliate'),
            'main_image' => '',
        ]);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            $imagePath = 'storage/' . $path;

            if ($index === 0) {
                $product->update([
                    'main_image' => $imagePath,
                ]);
            }

            $product->images()->create([
                'image_path' => $imagePath,
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',

            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',

            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $product->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'sizes' => $request->sizes,
            'colors' => $request->colors,
            'affiliate_url' => $request->affiliate_url,
            'is_affiliate' => $request->boolean('is_affiliate'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldImage->image_path));
                $oldImage->delete();
            }

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $imagePath = 'storage/' . $path;

                if ($index === 0) {
                    $product->update([
                        'main_image' => $imagePath,
                    ]);
                }

                $product->images()->create([
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}