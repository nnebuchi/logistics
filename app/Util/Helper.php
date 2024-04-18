<?php

namespace App\Util;

use App\Models\User;
use App\Models\Transaction;
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

    public static function getNewUsersLast7Days()
    {
        // Calculate the date 7 days ago from today
        $startDate = Carbon::now()->subDays(7);
        //$endDate = Carbon::now();

        // Fetch the total number of users registered in the last 7 days
        $totalUsers = User::whereDate('created_at', '>=', $startDate)->count();
        //$totalUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        return $totalUsers;
    }

    public static function fetchTransactionsCountInPastWeek()
    {
        // Calculate the start and end dates for the past week
        $startDate = Carbon::now()->subDays(7);

        // Fetch the total number of users registered between the start and end dates
        $totalTrx = Transaction::whereDate('created_at', '>=', $startDate)->count();

        return $totalTrx;
    }

    public static function fetchTransactionsCountInPastMonth()
    {
        // Calculate the date 1 month ago from today
        $startDate = Carbon::now()->subMonth();

        // Fetch the total number of users registered in the last 1 month
        $totalTrx = Transaction::whereDate('created_at', '>=', $startDate)->count();

        return $totalTrx;
    }

    public static function fetchTransactionsCostInPastWeek()
    {
        // Calculate the start and end dates for the past week
        $startDate = Carbon::now()->subDays(7);

        // Fetch the total number of users registered between the start and end dates
        $totalTrx = Transaction::whereDate('created_at', '>=', $startDate)->sum("amount");

        return $totalTrx;
    }

    public static function fetchTransactionsCostInPastMonth()
    {
        // Calculate the start and end dates for the past month
        $startDate = Carbon::now()->subMonth();

        // Fetch the total number of users registered between the start and end dates
        $totalTrx = Transaction::whereDate('created_at', '>=', $startDate)->sum("amount");

        return $totalTrx;
    }

    public static function calculateNewUsersPercentage()
    {
        // Get the date one month ago
        $oneMonthAgo = Carbon::now()->subMonth();

        // Count the total number of users
        $totalUsers = User::count();

        // Count the number of new users registered in the past month
        $newUsersCount = User::where('created_at', '>=', $oneMonthAgo)->count();

        // Calculate the percentage of new users
        $percentage = ($newUsersCount / $totalUsers) * 100;

        return $percentage;
    }

    public static function calculateTransactionsPercentage()
    {
        // Get the date one month ago
        $oneMonthAgo = Carbon::now()->subMonth();

        // Count the total number of users
        $totalTrx = Transaction::sum("amount");

        // Count the number of new users registered in the past month
        $newTrxCost = Transaction::where('created_at', '>=', $oneMonthAgo)->sum("amount");

        // Calculate the percentage of new users
        $percentage = ($newTrxCost / $totalTrx) * 100;

        return $percentage;
    }

    public static function userPercentageChange()
    {
        $currentMonth = Carbon::now(); // Get the current month

        // Calculate the start of the previous 30 days
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        // Calculate the end of the month before the previous 30 days
        return $previousMonthEnd = $previousMonthStart->copy()->subMonth()->endOfMonth();

        // Count new users for the current month
        $currentMonthNewUsers = User::whereDate('created_at', '>=', $currentMonth)->count();

        // Count new users for the previous month
        return $previousMonthNewUsers = User::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

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
