<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'brand',
        'price',
        'category',
        'image_url',
        'is_affiliate',
        'affiliate_url',
        'sizes',
        'colors'
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'is_affiliate' => 'boolean',
    ];

    /**
     * Filter products (category, size, color, sort)
     */
    public function scopeFilter($query, array $filters)
    {
        // Category filter
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });

        // Size filter (JSON column)
        $query->when($filters['size'] ?? null, function ($query, $size) {
            $query->whereJsonContains('sizes', $size);
        });

        // Color filter (JSON column)
        $query->when($filters['color'] ?? null, function ($query, $color) {
            $query->whereJsonContains('colors', $color);
        });

        // Sorting
        $query->when($filters['sort'] ?? null, function ($query, $sort) {
            match ($sort) {
                'price_high' => $query->orderBy('price', 'desc'),
                'price_low'  => $query->orderBy('price', 'asc'),
                default      => null,
            };
        });
    }

    /**
     * Check if product is favorited by user
     */
    public function isFavoritedBy($user): bool
    {
        if (!$user) return false;

        return DB::table('favorites')
            ->where('user_id', $user->id)
            ->where('product_id', $this->id)
            ->exists();
    }
}