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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            //$table->unsignedBigInteger('shipping_id');
            //$table->string('channel')->nullable();
            $table->integer('amount');
            $table->enum('type', ['Debit', 'Credit']);
            $table->enum('status', [
                'pending', 
                'success', 
                'failed'
            ])->default('pending');
            $table->string('reference')->unique();
            $table->boolean('verified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
