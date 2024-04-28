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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('sortname');
            $table->string('name');
            $table->integer('phonecode');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_short')->nullable();
            $table->string('currency_symbol')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
