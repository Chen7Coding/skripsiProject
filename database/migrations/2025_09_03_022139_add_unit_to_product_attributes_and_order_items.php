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
         // Tambahkan kolom unit ke product_attributes
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->string('unit', 50)->nullable()->after('size');
        });

        // Tambahkan kolom unit ke order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('unit', 50)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback kolom unit
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropColumn('unit');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
};
