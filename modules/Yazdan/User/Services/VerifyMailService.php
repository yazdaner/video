<?php

namespace Yazdan\User\Services;

class VerifyMailService
{

    public static function generateCode()
    {
        return random_int(100000,999999);
    }

    public static function cacheSet($id,$code)
    {
        cache()->set('verify_code_'.$id,$code,now()->addDay());
    }

    public static function cacheGet($id)
    {
        return cache()->get('verify_code_'.$id);
    }
    public static function cacheDelete($id)
    {
        return cache()->delete('verify_code_'.$id);
    }

    public static function check($code)
    {
        if ($code != self::cacheGet(auth()->id())) return false;

        self::cacheDelete(auth()->id());
        return true;
    }
}
