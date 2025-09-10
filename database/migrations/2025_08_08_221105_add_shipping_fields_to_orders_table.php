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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('kecamatan')->nullable();
        $table->integer('shipping_cost')->default(0);
       /*  // Jika Anda ingin mengaktifkan kembali kolom ini, hapus komentarnya
        $table->string('shipping_city')->nullable(); 
        $table->string('shipping_province')->nullable(); */
// Pastikan tidak ada karakter lain di dalam komentar
        $table->string('payment_image')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             // Menghapus kolom-kolom jika migrasi di-rollback
            $table->dropColumn([
                'kecamatan',
                'shipping_cost',
               /*  'shipping_city',
                'shipping_province', */
                'payment_image'
            ]);
        });
    }
};
