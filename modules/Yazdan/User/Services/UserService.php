<?php

namespace Yazdan\User\Services;

class UserService
{

    public static function updatePassword($user,$password)
    {
        $user->password = bcrypt($password);
        auth()->user()->save();
    }

}
