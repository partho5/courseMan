<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 8/25/18
 * Time: 1:45 PM
 */

namespace App\Lib;

use Illuminate\Support\Facades\DB;

class Library{



    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }


    public function generateRandomToken($length){
        $token = "";
        // O, o, 0, 1, l, I are not included to avoid confusion
        $codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijkmnpqrstuvwxyz";
        $codeAlphabet.= "23456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }

        return $token;
    }

    public function columnExist($tableName, $columnName, $columnValue){
        $row = DB::table($tableName)->where($columnName, $columnValue)->get();
        return count($row) > 0 ;
    }
}