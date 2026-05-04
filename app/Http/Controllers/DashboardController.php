<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // get the items the user favorited
        $favorites = $user->favoriteProducts()->latest()->take(4)->get();

        // get latest orders
        $orders = auth()->user()->orders()->with('items')->latest()->get();

        return view('dashboard', compact('favorites', 'orders'));
    }

    public function orderHistory()
    {
        //fFetch all order  user has ever made, newest first
        $orders = auth()->user()->orders()->with('items')->latest()->get();
        
        return view('orders.index', compact('orders'));
    }
}