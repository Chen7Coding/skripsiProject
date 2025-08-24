<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('whatsapp_number')->nullable();
    });

    Schema::table('settings', function (Blueprint $table) {
        $table->string('owner_whatsapp_number')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('whatsapp_number');
    });

    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn('owner_whatsapp_number');
    });
}
};
