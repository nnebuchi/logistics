<?php

namespace App\Util;

use App\Models\User;
use Carbon\Carbon;

class Helper
{
    public static function getDistance($latA, $lngA, $latB, $lngB)
    {
        $R = 6371000;
        $radiansLAT_A = deg2rad($latA);
        $radiansLAT_B = deg2rad($latB);
        $variationLAT = deg2rad($latB - $latA);
        $variationLNG = deg2rad($lngB - $lngA);

        $a = sin($variationLAT / 2) * sin($variationLAT / 2)
            + cos($radiansLAT_A) * cos($radiansLAT_B) * sin($variationLNG / 2) * sin($variationLNG / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $d = $R * $c;

        return $d / 1000;
    }

    public static function generateReference($id)
    {
        $token = "";
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet) - 1;
        for($i=0; $i<14; $i++):
            $token .= $codeAlphabet[mt_rand(0, $max)]; 
        endfor; 
        return $id.strtolower($token);
    }

    public static function fetchNewUsersCountInPastWeek()
    {
        $oneWeekAgo = Carbon::now()->subWeek(); // Calculate the date one week ago
        // Fetch new users created since one week ago
        $newUsersCount = User::where('created_at', '>=', $oneWeekAgo)->count();
        return $newUsersCount;
    }

    public static function fetchNewUsersCountInPastMonth()
    {
        $startDate = Carbon::now()->subMonth(); // Get the start date (one month ago)
        $endDate = Carbon::now(); // Get the end date (now)
        $newUsersCount = User::whereBetween('created_at', [$startDate, $endDate])->count();
        return $newUsersCount;
    }

    public function calculateNewUsersPercentage()
    {
        // Get the current date
        $now = Carbon::now();

        // Get the date one month ago
        $oneMonthAgo = $now->subMonth();

        // Count the total number of users
        $totalUsers = User::count();

        // Count the number of new users registered in the past month
        $newUsersCount = User::where('created_at', '>=', $oneMonthAgo)->count();

        // Calculate the percentage of new users
        $percentage = ($newUsersCount / $totalUsers) * 100;

        return $percentage;
    }

    public static function userPercentageChange()
    {
        $currentMonth = Carbon::now()->startOfMonth(); // Get the current month

        // Get the start and end dates of the previous month
        $previousMonthStart = $currentMonth->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $currentMonth->copy()->subMonth()->endOfMonth();

        // Count new users for the current month
        $currentMonthNewUsers = User::whereDate('created_at', '>=', $currentMonth)->count();

        // Count new users for the previous month
        $previousMonthNewUsers = User::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        // Calculate percentage change
        if ($previousMonthNewUsers != 0) {
            $percentageChange = (($currentMonthNewUsers - $previousMonthNewUsers) * 100) / $previousMonthNewUsers;
            $percentageChange = ((30000 - 0) * 100) / 0;
        } else {
            // Handle the case when there are no new users in the previous month
            $percentageChange = 100; // Arbitrary value to indicate a significant increase
        }

        return $percentageChange;
    }
}
