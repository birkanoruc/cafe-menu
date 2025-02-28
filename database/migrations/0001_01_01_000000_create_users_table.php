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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kullanıcı kimliği
            $table->string('firstname'); // Kullanıcı adı
            $table->string('lastname'); // Kullanıcı soyadı
            $table->string('username')->unique(); // Kullanıcı adı
            $table->string('email')->unique(); // Kullanıcı e-postası
            $table->timestamp('email_verified_at')->nullable(); // E-posta doğrulama zamanı
            $table->string('password'); // Kullanıcı şifresi
            $table->rememberToken(); // Oturum açma tokeni
            $table->timestamps(); // Kullanıcı oluşturulma ve güncellenme zamanları
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('email_verification_tokens', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
