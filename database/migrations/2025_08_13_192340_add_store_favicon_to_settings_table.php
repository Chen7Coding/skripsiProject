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
            Schema::table('settings', function (Blueprint $table) {
                // Tambahkan kolom 'store_favicon'
                $table->string('store_favicon')->nullable()->after('store_logo');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('settings', function (Blueprint $table) {
                // Hapus kolom jika rollback
                $table->dropColumn('store_favicon');
            });
        }
};
