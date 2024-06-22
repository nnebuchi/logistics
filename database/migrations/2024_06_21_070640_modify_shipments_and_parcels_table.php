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
            // Drop the unique constraint
            // $table->dropUnique('shipments_external_shipment_id_unique');
            // Modify the column to be nullable
            $table->string('external_shipment_id')->nullable()->change();
        });

        Schema::table('parcels', function (Blueprint $table) {
            $table->text('metadata')->after("external_parcel_id")->nullable();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->string('currency')->nullable()->change(); 
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // Revert the changes made in the up method
            $table->string('external_shipment_id')->nullable(false)->change();
            // $table->unique('external_shipment_id');
        });

        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn('metadata');
        });

        Schema::table('items', function (Blueprint $table) {
            // Revert the changes made in the up method
            $table->string('currency');
        });
    }
};
