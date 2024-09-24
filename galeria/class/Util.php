<?php
/*
* @App     Dream Gallery 2.0
* @Author  Rafael Clares <falecom@phpstaff.com.br> 
* @Web     www.phpstaff.com.br
*/
class Util {

    static function redirect($url) {
        @header("Location: $url");
    }

    static function lrtrim($str) {
        return rtrim(ltrim(trim($str)));
    }

    static function maiscula($str) {
        return strtolower($str);
    }

    static function agora() {
        return date('d/m/Y H:i:s');
    }

    static function slug($str) {
        return preg_replace('/\s+/', '-', $str);
    }

    static function cortar($str, $chars, $info = '') {
        $str = strip_tags($str);
        if (strlen($str) >= $chars) {
            $str = preg_replace('/\s\s+/', ' ', $str);
            $str = preg_replace('/\s\s+/', ' ', $str);
            $str = substr($str, 0, $chars);
            $str = preg_replace('/\s\s+/', ' ', $str);
            $arr = explode(' ', $str);
            array_pop($arr);
            $final = implode(' ', $arr) . $info;
        } else {
            $final = $str;
        }
        return $final;
    }
}
