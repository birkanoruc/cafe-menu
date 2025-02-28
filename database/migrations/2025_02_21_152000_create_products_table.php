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
            $table->id(); // Ürün kimliği
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade'); // Ürünün mekan kimliği
            $table->string('name'); // Ürünün adı
            $table->string('slug'); // Ürünün kısa adı
            $table->text('description')->nullable(); // Ürünün açıklaması
            $table->decimal('price', 10, 2); // Ürünün fiyatı
            $table->decimal('discount_price', 10, 2)->nullable(); // Ürünün indirimli fiyatı
            $table->string('featured_image'); // Ürünün öne çıkan resmi
            $table->timestamps(); // Ürünün oluşturulma ve güncellenme zamanları
            $table->unique(['venue_id', 'slug']); // Mekan kimliği bazında ürün kısa adınının tekrar olmasını önler.
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
