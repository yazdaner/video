<?php
namespace Yazdan\Course\App\Http\Requests;

use Illuminate\Validation\Rule;
use Yazdan\Course\App\Rules\ValidSeason;
use Illuminate\Foundation\Http\FormRequest;
use Yazdan\Course\Repositories\LessonRepository;

class LessonRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            "title" => 'required|min:3|max:190',
            "slug" => 'nullable|min:3|max:190',
            "priority" => 'nullable|numeric',
            "time" => 'nullable|numeric',
            "type" => ['required',Rule::in(LessonRepository::$types)],
            "season_id" => ['nullable',new ValidSeason],
            "lesson_file" => 'nullable|file|mimes:mp4,avi,mkv,mov,zip,rar',

        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            "title" => 'عنوان درس',
            "slug" => 'عنوان انگلیسی درس',
            "number" => 'شماره درس',
            "time" => 'مدت زمان درس',
            "season_id" => "سرفصل",
            "free" => "رایگان",
            "lesson_file" => "فایل درس",
            "body" => "توضیحات درس"
        ];
    }


}
