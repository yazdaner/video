<?php

namespace Yazdan\Course\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Yazdan\User\Repositories\UserRepository;

class ValidTeacher implements Rule
{

    public function passes($attribute, $value)
    {
       $user = UserRepository::findById($value);
       return $user->hasPermissionTo('teach');
    }

    public function message()
    {
        return "کاربر انتخاب شده یک مدرس معتبر نیست.";
    }
}



