<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
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