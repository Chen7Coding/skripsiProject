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
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama kecamatan, harus unik (tidak boleh ada yang sama)
            $table->string('city')->default('Kabupaten Bandung'); // Nama kota/kabupaten
            $table->unsignedInteger('shipping_cost')->default(0); // Ongkos kirim untuk kecamatan ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
