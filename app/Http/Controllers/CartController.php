<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 


class CartController extends Controller
{
    
    public function add(Product $product) {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url,
                "brand" => $product->brand

            ];
        }
        session()->put('cart', $cart);
        
        return back()->with('success', 'Added to cart!');
    }

}
