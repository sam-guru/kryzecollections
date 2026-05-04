<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Support\Str;

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
    public function complete(Request $request)
    {
        $cart = session('cart');
        if (!$cart) return redirect('/');

        // 1. get the address used (passed from review page or stored in session)
        $address = ShippingAddress::find($request->address_id);
        $addressString = "{$address->address_line_1}, {$address->city}, {$address->postcode}";

        // 2. create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'shipping_address' => $addressString,
        ]);

        // save each item
        foreach ($cart as $item) {
            $order->items()->create([
                'product_name' => $item['name'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // cflear cart
        session()->forget('cart');

        return view('checkout-success');
    }
}