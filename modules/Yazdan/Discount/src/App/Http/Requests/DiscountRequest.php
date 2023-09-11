<?php

namespace Yazdan\Discount\App\Http\Requests;

use Yazdan\Discount\App\Rules\ValidJalaliDate;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            "code" => "nullable|max:50|unique:discounts,code",
            "percent" => "required|numeric|min:1|max:100",
            "usage_limitation" => "nullable|numeric|min:1|max:1000000000",
            "expire_at" => ["nullable",new ValidJalaliDate()],
            "courses" => "nullable|array",
            "type" => "required"
        ];

        if (request()->getMethod() == "PUT"){
            $rules["code"] = "nullable|max:50|unique:discounts,code," . request()->route("discount")->id;
        }

        return $rules;

    }

    public function attributes()
    {
        return [
            "code" => "کد تخفیف",
            "percent" => "درصد تخفیف",
            "usage_limitation" => "محدودیت افراد",
            "courses" => "آیتم",
            "type" => "نوع تخفیف",
        ];
    }

}
