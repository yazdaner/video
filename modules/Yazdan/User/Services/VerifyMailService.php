<?php

namespace Yazdan\User\Services;

class VerifyMailService
{

    private static $min = 100000;
    private static  $max= 999999;
    private static $prefix = 'verify_code_';

    public static function generateCode()
    {
        return random_int(self::$min,self::$max);
    }

    public static function cacheSet($id,$code,$time)
    {
        cache()->set(self::$prefix . $id,$code,$time);
    }

    public static function cacheGet($id)
    {
        return cache()->get(self::$prefix . $id);
    }

    public static function cacheHas($id)
    {
        return cache()->has(self::$prefix . $id);
    }

    public static function cacheDelete($id)
    {
        return cache()->delete(self::$prefix . $id);
    }

    public static function check($id,$code)
    {
        if ($code != self::cacheGet($id)) return false;

        self::cacheDelete($id);
        return true;
    }
}
