<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'firstname' => "Summer",
            'lastname' => "Walker",
            'email' => "summer06@gmail.com",
            'email_verified_at' => now(),
            'phone' => '+2348155678797',
            'password' => 'Reckless@3030', // Reckless@3030
        ]);
    }
}
