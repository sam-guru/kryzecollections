<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        
        //  get the inputs from the form
        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = (int) $request->input('quantity', 1);

        //  create a unique ID for this specific variation
        // Example: "14-M-Blue"
        $cartKey = $product->id . '-' . ($size ?? 'no-size') . '-' . ($color ?? 'no-color');

        $cart = session()->get('cart', []);
        $image = $this->formatImagePath($product->main_image);

        //  check if THIS specific variation is already in the cart
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            // add new item with size and color details
            $cart[$cartKey] = [
                'product_id' => $product->id, // keep the real ID for database later
                'name' => $product->name,
                'brand' => $product->brand,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $image,
                'size' => $size,
                'color' => $color,
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


    public function remove($key) // Change $id to $key
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$key])) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);
        return back()->with('success', 'Product removed.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }
}