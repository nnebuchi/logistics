<?php


use Illuminate\Support\Str;

if (!function_exists('generateOTP')) {

    function generateOTP()
    {   
        // Generates Random number between given pair
        return mt_rand(10000, 99999);
    }

    function slugify(String $string)
    {
        return preg_replace('/[^a-zA-Z0-9_\']/','_', $string).'-'.Str::random(5);
    }

    /**
     * Generate reference for payments
     *
     * @param  Int $id of the patient
     * @return String
    */
    function generateReference(int $id)
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

    /**
     * Get the distance between two coordinates in kilometres/miles
     *
     * @param  Double latitude A
     * @param  Double longitude A
     * @param  Double latitude B
     * @param  Double longitude B
     * @return Int
    */
    function getDistance($latA, $lngA, $latB, $lngB)
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
}
