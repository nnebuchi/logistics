<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = ['personal', 'business', '3pl'];
        
        foreach ($accounts as $account):
            Account::create(["name" => $account]);
        endforeach;
    }
}
