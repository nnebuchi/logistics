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
        $newUsersCount = User::whereDate('created_at', '>=', $startDate)->count();
        //$totalUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        $totalUsers = User::count();
        // Calculate the percentage of new users
        $percentage = ($newUsersCount / $totalUsers) * 100;

        return [$newUsersCount, $percentage];
    }

    public static function fetchTransactionsCostInPastWeek()
    {
        // Calculate the start and end dates for the past week
        $startDate = Carbon::now()->subDays(7);

        // Fetch the total number of users registered between the start and end dates
        $newTrxCost = Transaction::whereDate('created_at', '>=', $startDate)->sum("amount");

        $totalTrx = Transaction::all()->sum("amount");
        // Calculate the percentage of new users
        $percentage = ($newTrxCost / $totalTrx) * 100;

        return [$newTrxCost, $percentage];
    }

    public static function fetchTransactionsCostInPastMonth()
    {
        // Calculate the start and end dates for the past month
        $startDate = Carbon::now()->subMonth();

        // Fetch the total number of users registered between the start and end dates
        $newTrxCost = Transaction::whereDate('created_at', '>=', $startDate)->sum("amount");

        $totalTrx = Transaction::all()->sum("amount");
        // Calculate the percentage of new users
        $percentage = ($newTrxCost / $totalTrx) * 100;

        return [$newTrxCost, $percentage];
    }

}
