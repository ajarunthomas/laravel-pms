<?php

namespace App\customClass;

class helpers{
    public static function getToken($token){
        return explode('|', $token)[1];
    }

    public static function slugify($text, string $divider = '-'){
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function generateOrderNumber(){
        $length = 6;    
        return "LP".substr(str_shuffle('123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
    }
}