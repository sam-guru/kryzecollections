<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class FavoriteController extends Controller
{
    //

    public function toggle(Product $product)
    {
        $user = auth()->user();
        
        // If already favorited, remove it. Otherwise, add it.
        if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);
        } else {
            $user->favoriteProducts()->attach($product->id);
        }

        return back();
    }
}
