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
        Schema::create('product_category', function (Blueprint $table) {
            $table->id(); // Ürün-Kategori ilişkisi kimliği
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Ürünün kimliği
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Kategorinin kimliği
            $table->timestamps(); // Ürün-Kategori ilişkisinin oluşturulma ve güncellenme zamanları
            $table->unique(['product_id', 'category_id']); // Aynı ürün aynı kategoriye birden fazla eklenemesini önler.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
