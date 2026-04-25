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
        'description',
        'main_image',
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
     * Relationships
     */

    // 🔥 Multiple product images (gallery)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Filter products (category, size, color, sort)
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'] ?? null, fn($q, $cat) =>
            $q->where('category', $cat)
        );

        $query->when($filters['size'] ?? null, fn($q, $size) =>
            $q->whereJsonContains('sizes', $size)
        );

        $query->when($filters['color'] ?? null, fn($q, $color) =>
            $q->whereJsonContains('colors', $color)
        );

        $query->when($filters['sort'] ?? null, function ($q, $sort) {
            match ($sort) {
                'price_high' => $q->orderBy('price', 'desc'),
                'price_low'  => $q->orderBy('price', 'asc'),
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