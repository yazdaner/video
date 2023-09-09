<?php
namespace Yazdan\Course\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeasonRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            "title" => 'required|min:3|max:190',
            "number" => 'nullable|numeric|min:0|max:250',
        ];

        return $rules;

    }

    public function attributes()
    {
        return [
            "title" => "عنوان سرفصل",
            "number" => "شماره سرفصل",
        ];
    }


}
