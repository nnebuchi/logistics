<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Admin::create([
            'firstname' => "Stephanie",
            'lastname' => "Omoruyi",
            'email' => "summer07@gmail.com",
            'email_verified_at' => now(),
            'phone' => '+2348155678725',
            'password' => 'Reckless@3030', // Reckless@3030
        ]);

        // Find the role by name
        $role = Role::where('name', 'admin')->first();

        // Assign the role to the user
        $user->assignRole($role);
    }
}
