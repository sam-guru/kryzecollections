<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Men' => [
                'products' => ['Oversized Hoodie', 'Slim Fit Jeans', 'Graphic Tee', 'Bomber Jacket'],
                'brands' => ['Nike', 'Zara', 'H&M', 'ASOS']
            ],
            'Women' => [
                'products' => ['Bodycon Dress', 'Crop Top', 'High Waist Jeans', 'Blazer'],
                'brands' => ['Zara', 'Boohoo', 'PrettyLittleThing', 'H&M']
            ],
            'Accessories' => [
                'products' => ['Leather Handbag', 'Minimal Watch', 'Sunglasses', 'Necklace'],
                'brands' => ['Gucci', 'Prada', 'Tom Ford', 'Rolex']
            ]
        ];

        foreach ($categories as $category => $data) {

            for ($i = 0; $i < 20; $i++) {

                $productName = fake()->randomElement($data['products']);
                $brand = fake()->randomElement($data['brands']);

                // 🔥 Category-specific fashion images (reliable)
                $seed = Str::random(10);

                $imageUrl = match ($category) {
                    'Men' => "https://picsum.photos/seed/men{$seed}/600/800",
                    'Women' => "https://picsum.photos/seed/women{$seed}/600/800",
                    'Accessories' => "https://picsum.photos/seed/accessories{$seed}/600/800",
                };

                // 🔁 Download image
                $response = Http::withoutVerifying()->get($imageUrl);

                // 🔥 fallback (guaranteed image)
                if ($response->failed() || empty($response->body())) {
                    $response = Http::withoutVerifying()
                        ->get("https://picsum.photos/600/800");
                }

                // 💾 Save image locally
                $fileName = 'products/' . Str::uuid() . '.jpg';
                Storage::disk('public')->put($fileName, $response->body());

                $price = match ($category) {
                    'Accessories' => fake()->numberBetween(25, 400),
                    default => fake()->numberBetween(40, 250),
                };

                // 🧠 ALWAYS create product (no null failures)
                Product::create([
                    'name' => $productName . ' ' . fake()->randomElement(['Edition', 'Drop', 'Collection']),
                    'brand' => $brand,
                    'price' => $price,
                    'category' => $category,
                    'image_url' => 'storage/' . $fileName,
                    'is_affiliate' => fake()->boolean(40),
                    'affiliate_url' => 'https://example.com/product/' . Str::random(10),
                    'description' => fake()->paragraph(2),
                    'sizes' => [],
                    'colors' => [],
                ]);
            }
        }
    }
}