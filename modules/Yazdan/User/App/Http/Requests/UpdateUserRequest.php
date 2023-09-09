<?php

namespace Yazdan\User\App\Http\Requests;

use Yazdan\User\App\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;
use Yazdan\User\App\Rules\ValidMobile;
use Illuminate\Validation\Rule;
use Yazdan\User\Repositories\UserRepository;

class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }


    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required','email','unique:users,email,'. request()->route('user')],
            'status' => ['required',Rule::in(UserRepository::$statuses)],
            'password' => ['nullable',new ValidPassword],
            'mobile' => ['nullable',new ValidMobile,'unique:users,mobile,'. request()->route('user')],
        ];
    }
}
