<?php

namespace Yazdan\RolePermissions\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => ['required','min:3','unique:roles,name'],
            'permissions' => ['required','array','min:1'],
        ];

        if (request()->method === 'PUT') {
            $rules['name'] = ['required','min:3','unique:roles,name,'.request()->route('role')];
        }

        return $rules;

    }

    public function attributes()
    {
        return [
            "permissions" => "مجوزها",
        ];
    }
}
