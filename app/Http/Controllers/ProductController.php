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
}
