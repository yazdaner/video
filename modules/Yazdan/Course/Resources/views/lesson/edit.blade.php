@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="{{ route('admin.courses.index') }}" title="دوره ها">دوره ها</a></li>
<li><a href="{{ route('admin.courses.details',$lesson->course->id) }}" title="جزِییات دوره">جزِییات دوره</a></li>
<li><a href="#" title="ایجاد درس">ویراش درس</a></li>
@endsection
@section('content')
<div class="main-content padding-0 course__detial">
    <p class="box__title">ویراش درس</p>
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <form action="{{ route('admin.lessons.update',$lesson->id) }}" class="padding-30" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-input type="text" name="title" placeholder="عنوان درس" value="{{$lesson->title}}" />
                <x-input type="text" class="text-left" name="slug" placeholder="نام انگلیسی درس"
                    value="{{$lesson->slug}}" />

                <x-input type="number" name="priority" placeholder="شماره جلسه" value="{{$lesson->priority}}" />
                <x-input type="number" name="time" placeholder="مدت زمان درس" value="{{$lesson->time}}" />

                <p class="box__title">ایا این درس رایگان است ؟ </p>
                <div class="w-50">
                    <div class="notificationGroup">
                        <input id="type-1" name="type"
                            value="{{\Yazdan\Course\Repositories\LessonRepository::TYPE_CASH}}" type="radio" @if($lesson->type == \Yazdan\Course\Repositories\LessonRepository::TYPE_CASH) checked @endif>
                        <label for="type-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="type-2" name="type"
                            value="{{\Yazdan\Course\Repositories\LessonRepository::TYPE_FREE}}" type="radio" @if($lesson->type == \Yazdan\Course\Repositories\LessonRepository::TYPE_FREE) checked @endif>
                        <label for="type-2">بله</label>
                    </div>
                </div>


                @if (count($seasons))
                    <x-select name="season_id" placeholder="انتخاب سرفصل درس">
                        @foreach ($seasons as $season)
                        <option value="{{$season->id}}" @if($season->id == $lesson->season_id) selected
                            @endif>{{$season->title}}</option>
                        @endforeach
                    </x-select>
                @endif

                <x-file-upload name="lesson_file" placeholder="آپلود درس" :value="$lesson->media"/>


                <x-text-area name="body" placeholder="توضیحات درس" value="{{$lesson->body}}" />

                <x-button title="ویراش درس" />
            </form>
        </div>
    </div>
</div>
@endsection

