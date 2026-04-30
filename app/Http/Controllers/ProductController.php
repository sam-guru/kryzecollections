<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::query()
        ->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%");
        })
        ->filter($request->only(['category', 'size', 'color', 'sort']))
        ->latest()
        ->paginate(12); // Always paginate for a professional look

        return view('shop', compact('products'));
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'sizes' => $request->sizes,
            'colors' => $request->colors,
            'is_affiliate' => $request->is_affiliate ?? false,
            'affiliate_url' => $request->affiliate_url,
            'main_image' => $this->upload($request->file('main_image')),
        ]);

        // multiple images (max 5)
        if ($request->hasFile('images')) {
            foreach (array_slice($request->file('images'), 0, 5) as $image) {
                $product->images()->create([
                    'image_path' => $this->upload($image)
                ]);
            }
        }

        return redirect()->back();
    }

    private function upload($file)
    {
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/products', $name);
        return 'storage/products/' . $name;
    }

    public function show(Product $product)
    {
        // load the images but exclude the one that matches the main_image path
        $gallery = $product->images()
            ->where('image_path', '!=', $product->main_image)
            ->get();

        return view('product.show', compact('product', 'gallery'));    
    }
}
