<?php

namespace Yazdan\User\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Yazdan\User\App\Rules\ValidPassword;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required',new ValidPassword,'confirmed'],
        ];
    }
}
