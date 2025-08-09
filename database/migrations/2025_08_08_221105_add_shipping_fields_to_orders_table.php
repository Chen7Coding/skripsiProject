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
             $table->string('kecamatan')->nullable()->after('shipping_address');
            $table->integer('shipping_cost')->default(0)->after('kecamatan');
            $table->string('shipping_city')->nullable()->after('shipping_cost');
            $table->string('shipping_province')->nullable()->after('shipping_city');
            $table->string('payment_image')->nullable()->after('shipping_postal_code');
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
                'shipping_city',
                'shipping_province',
                'payment_image'
            ]);
        });
    }
};
