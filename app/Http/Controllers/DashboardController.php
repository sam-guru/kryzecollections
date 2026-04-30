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

        // placeholder for orders (we will update this later)
        $orders = [];

        return view('dashboard', compact('favorites', 'orders'));
    }
}