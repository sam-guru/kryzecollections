<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
    ];

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['category'] ?? null, fn($q, $cat) => $q->where('category', $cat));

        // Filter by Size (searches inside the JSON array)
        $query->when($filters['size'] ?? null, function ($q, $size) {
            $q->whereJsonContains('sizes', $size);
        });

        // Filter by Colour
        $query->when($filters['color'] ?? null, function ($q, $color) {
            $q->whereJsonContains('colors', $color);
        });
        
        // filter by category
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });

        // sort by price
        $query->when($filters['sort'] ?? null, function ($query, $sort) {
            if ($sort === 'price_high') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'price_low') {
                $query->orderBy('price', 'asc');
            }
        });
    }

    public function isFavoritedBy($user)
    {
        if (!$user) return false;
        return \DB::table('favorites')
            ->where('user_id', $user->id)
            ->where('product_id', $this->id)
            ->exists();
    }

}
