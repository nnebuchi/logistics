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

    public static function getNewUsersLastWeek()
    {
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
        $usersLastWeek = User::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();

        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();
        $usersThisWeek = User::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->count();

        // Calculate the percentage of new users
        if($usersLastWeek == 0):
            $percentage = 100;
        else:
            $percentage = (($usersThisWeek - $usersLastWeek) * 100) / $usersLastWeek;
        endif;
        
        return [$usersThisWeek, $percentage];
    }

    public static function fetchTransactionsCostInPastWeek()
    {
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
        $trxLastWeek = Transaction::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->sum("amount");

        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();
        $trxThisWeek = Transaction::whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])->sum("amount");

        // Calculate the percentage change in transactions
        if($trxLastWeek == 0):
            $percentage = 100;
        else:
            $percentage = (($trxThisWeek - $trxLastWeek) * 100) / $trxLastWeek;
        endif;

        return [$trxThisWeek, $percentage];
    }

    public static function fetchTransactionsCostInPastMonth()
    {
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $trxLastMonth = Transaction::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum("amount");
        
        $startOfThisMonth = Carbon::now()->startOfMonth();
        $endOfThisMonth = Carbon::now()->endOfMonth();
        $trxThisMonth = Transaction::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->sum("amount");

        // Calculate the percentage change in transactions
        if ($trxLastMonth == 0) {
            $percentage = 100;
        } else {
            $percentage = (($trxThisMonth - $trxLastMonth) * 100) / $trxLastMonth;
        }

        return [$trxThisMonth, $percentage];
    }

}
