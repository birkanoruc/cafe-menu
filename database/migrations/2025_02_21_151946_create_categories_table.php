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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Kategori kimliği
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade'); // Kategorinin mekan kimliği
            $table->string('name'); // Kategorinin adı
            $table->string('slug'); // Kategorinin kısa adı
            $table->string('featured_image'); // Kategorinin öne çıkan resmi
            $table->timestamps(); // Kategorinin oluşturulma ve güncellenme zamanları
            $table->unique(['venue_id', 'slug']); // Mekan kimliği bazında kategori kısa adınının tekrar olmasını önler.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
