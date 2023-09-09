@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="{{ route('admin.courses.index') }}" title="دوره ها">دوره ها</a></li>
<li><a href="{{ route('admin.courses.details',$course->id) }}" title="جزِییات دوره">جزِییات دوره</a></li>
<li><a href="#" title="ایجاد درس جدید">ایجاد درس جدید</a></li>
@endsection
@section('content')
<div class="main-content padding-0">
    <p class="box__title">ایجاد درس جدید</p>
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <form action="{{ route('admin.lessons.store',$course->id) }}" class="padding-30" method="post"
                enctype="multipart/form-data">
                @csrf

                <x-input type="text" name="title" placeholder="عنوان درس" />
                <x-input type="text" class="text-left" name="slug" placeholder="نام انگلیسی درس" />

                <x-input type="number" name="priority" placeholder="شماره جلسه" />
                <x-input type="number" name="time" placeholder="مدت زمان درس" />

                <p class="box__title">ایا این درس رایگان است ؟ </p>
                <div class="w-50">
                    <div class="notificationGroup">
                        <input id="type-1" name="type" value="{{\Yazdan\Course\Repositories\LessonRepository::TYPE_CASH}}" type="radio" checked>
                        <label for="type-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="type-2" name="type" value="{{\Yazdan\Course\Repositories\LessonRepository::TYPE_FREE}}" type="radio">
                        <label for="type-2">بله</label>
                    </div>
                </div>

                @if (count($seasons))
                    <x-select name="season_id" placeholder="انتخاب سرفصل درس">
                        @foreach ($seasons as $season)
                        <option value="{{$season->id}}" @if (old('lesson')==$season->title) selected
                            @endif>{{$season->title}}</option>
                        @endforeach
                    </x-select>
                @endif


                <x-file-upload name="lesson_file" placeholder="آپلود درس" />

                <x-text-area name="body" placeholder="توضیحات درس" />

                <x-button title="ایجاد درس" />

            </form>
        </div>
    </div>
</div>
@endsection
