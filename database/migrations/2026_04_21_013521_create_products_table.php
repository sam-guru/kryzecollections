<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('brand')->nullable();
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->string('category');
        
        $table->string('main_image');

        $table->json('sizes')->nullable();
        $table->json('colors')->nullable();

        $table->string('affiliate_url')->nullable(); // made nullable since local items don't need it
        $table->boolean('is_affiliate')->default(false); 
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
