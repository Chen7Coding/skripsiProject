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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel products
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Harga per item saat ditambahkan ke keranjang
            $table->string('material')->nullable(); // Sesuai dengan opsi cartItem Anda
            $table->string('size')->nullable();     // Sesuai dengan opsi cartItem Anda
            $table->text('notes')->nullable();      // Sesuai dengan opsi cartItem Anda
            $table->string('design_file_path')->nullable(); // Sesuai dengan opsi cartItem Anda
            $table->timestamps();

            // Pastikan satu produk hanya ada satu kali di keranjang per user
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
