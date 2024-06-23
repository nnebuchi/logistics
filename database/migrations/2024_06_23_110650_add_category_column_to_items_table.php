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
        Schema::table('items', function (Blueprint $table) {
            $table->string('category')->nullable()->after('weight'); 
            $table->string('sub_category')->nullable()->after('category'); 
            $table->string('hs_code')->nullable()->after('sub_category'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                "category",
                "sub_category",
                "hs_code"
            ]);
        });
    }
};
