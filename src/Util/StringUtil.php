<?php


namespace App\Util;


class StringUtil {

    public static function startsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    public static function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

}