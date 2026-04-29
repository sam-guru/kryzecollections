<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();
        
        // check if it already exists
        $isFavorite = $user->favoriteProducts()->where('product_id', $product->id)->exists();

        if ($isFavorite) {
            $user->favoriteProducts()->detach($product->id);
            $status = 'Removed from favorites.';
        } else {
            $user->favoriteProducts()->attach($product->id);
            $status = 'Added to favorites!';
        }

        // return back to the shop page with flash message
        return back()->with('success', $status);
    }
}