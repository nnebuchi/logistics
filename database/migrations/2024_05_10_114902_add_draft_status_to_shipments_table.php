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
        Schema::table('shipments', function (Blueprint $table) {
            $table->enum('status', [
                'draft',
                'confirmed', 
                'in-transit', 
                'delivered',
                'cancelled'
            ])->change()->default('draft');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->enum('status', [
                'confirmed', 
                'in-transit', 
                'delivered',
                'cancelled'
            ])->default('confirmed');
        });
    }
};
