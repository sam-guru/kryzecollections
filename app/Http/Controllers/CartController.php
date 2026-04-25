<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        $image = $this->formatImagePath($product->main_image);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['image'] = $image;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'brand' => $product->brand,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Added to cart!');
    }

    private function formatImagePath(?string $image): string
    {
        if (!$image) {
            return 'images/placeholder.jpg';
        }

        $image = ltrim($image, '/');

        if (str_starts_with($image, 'storage/')) {
            return $image;
        }

        if (str_starts_with($image, 'products/')) {
            return 'storage/' . $image;
        }

        return $image;
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        unset($cart[$id]);

        session()->put('cart', $cart);

        return back()->with('success', 'Product removed.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }
}