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
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('account_name')->nullable()->change();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('bank_name')->change();
            $table->string('account_number')->change();
            $table->string('account_name')->change();  
        });
    }
};
