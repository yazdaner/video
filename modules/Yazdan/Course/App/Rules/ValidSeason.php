<?php

namespace Yazdan\Course\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Yazdan\Course\Repositories\LessonRepository;
use Yazdan\User\Repositories\UserRepository;

class ValidSeason implements Rule
{

    public function passes($attribute, $value)
    {
        $lesson = LessonRepository::findSeasonOfCourse($value,request()->route('course'));
        if($lesson){
            return true;
        }
        return false;
    }

    public function message()
    {
        return "سرفصل انتخاب شده معتبر نمی باشد.";
    }
}



