<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true), 
            'brand' => fake()->randomElement(['Nike', 'Adidas', 'Tommy Hilfiger', 'Puma', 'Levis']),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 25, 250),
            // High-quality random fashion-style images
            'image_url' => 'https://picsum.photos' . fake()->uuid() . '/600/800', 
            'affiliate_url' => 'https://awin.com',
            'category' => fake()->randomElement(['Men', 'Women', 'Accessories']),
            // JSON fields for our filters
            'sizes' => fake()->randomElements(['XS', 'S', 'M', 'L', 'XL', '2XL'], rand(2, 4)),
            'colors' => fake()->randomElements(['Black', 'White', 'Navy', 'Grey', 'Beige', 'Red'], rand(1, 3)),
        ];
    }
}
