<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creeate 80 unique product
        for ($i = 1; $i <= 80; $i++) {
            $imageName = "product_{$i}.jpg";
            $imageUrl = "https://picsum.photos"; // Or a specific fashion API

            // download the image locally
            $imageContent = file_get_contents($imageUrl);
            
            // save image to storage/app/public/products
            Storage::disk('public')->put("products/{$imageName}", $imageContent);

            // create database record
            Product::factory()->create([
                'image_url' => "storage/products/{$imageName}",
                'is_affiliate' => fake()->boolean(50), // 50% chance to be affiliate or cart
            ]);
        }

    }
}
