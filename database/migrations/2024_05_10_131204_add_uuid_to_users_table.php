<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the UUID column
            $table->uuid('uuid')->after("id")->nullable()->unique();
        });

        // Generate UUIDs for existing users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->uuid = Uuid::uuid4()->toString();
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the UUID column
            $table->dropColumn('uuid');
        });
    }
};
