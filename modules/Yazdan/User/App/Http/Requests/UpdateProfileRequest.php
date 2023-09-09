<?php

namespace Yazdan\User\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Rules\ValidMobile;
use Yazdan\User\App\Rules\ValidPassword;

class UpdateProfileRequest extends FormRequest
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
        $rules = [
            'name' => ['required','min:3','max:190'],
            'username' => ['nullable','min:3','max:190','unique:users,username,'.auth()->id()],
            'mobile' => ['nullable',new ValidMobile,'unique:users,mobile,'.auth()->id()],
        ];

        if(auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_TEACH) ||
            auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN))
        {
            $rules += [
                'shaba' => ['nullable','string','size:24'],
                'card_number' => ['nullable','string','size:16'],
                'headline' => ['nullable','min:3','max:190'],
                'bio' => ['nullable'],
            ];

            $rules['username'] = ['nullable','min:3','max:190','unique:users,username,'.auth()->id()];
        }

        return $rules;

    }

    public function attributes()
    {
        return [
            'card_number' => 'شماره کارت بانکی',
            'shaba' => 'شماره شبا بانکی',
            'headline' => 'عنوان',
            'bio' => 'درباره من',
        ];
    }
}
