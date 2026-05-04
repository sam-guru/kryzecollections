<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class CheckoutController extends Controller
{
    //select address
    public function selectAddress()
    {
        // get all saved addresses for the user 
        $addresses = auth()->user()->shippingAddresses()->get();  

        // if the cart is empty, redirect back to shop
        if (!session()->has('cart') || count(session('cart')) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.select-address', [
        'addresses' => $addresses
        ]);
    }

    //review order
    public function reviewOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:shipping_addresses,id'
        ]);

        $address = ShippingAddress::find($request->address_id);
        $cart = session('cart', []);
        
        // Convert to collection for easier math
        $cartCollection = collect($cart);
        $subtotal = $cartCollection->sum(fn($item) => $item['price'] * $item['quantity']);
        
        // In a real app, you'd calculate shipping here
        $shipping = 0.00; 
        $total = $subtotal + $shipping;

        return view('checkout.review', compact('address', 'cart', 'subtotal', 'shipping', 'total'));
    }

    //complte checkout
    public function complete()
    {
        // clear cart data from the session
        if (session()->has('cart')) {
            session()->forget('cart');
            session()->flash('success', 'Simulation complete. Cart has been reset.');
        }

        return view('checkout-success');
    }
}