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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('phonecode')->change();
            $table->dropColumn([
                "lat",
                "lng",
                "currency_name",
                "currency_short",
                "currency_symbol"
            ]); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->integer('phonecode');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_short')->nullable();
            $table->string('currency_symbol')->nullable();
        });
    }
};
