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
        Schema::create('venues', function (Blueprint $table) {
            $table->id(); // Mekan kimliği
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Mekanın sahibi kimliği
            $table->string('name'); // Mekan adı
            $table->string('slug')->unique(); // Mekan kısa adı
            $table->string('address')->nullable(); // Mekan adresi
            $table->string('phone')->nullable(); // Mekan telefon numarası
            $table->string('featured_image'); // Mekan öne çıkan resmi
            $table->timestamps(); // Mekan oluşturulma ve güncellenme zamanları
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
