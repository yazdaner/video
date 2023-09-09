@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('admin.courses.index') }}" title="دوره ها">دوره ها</a></li>
    <li><a href="#" title="ویراش دوره">ویراش دوره</a></li>
@endsection
@section('content')
<div class="main-content padding-0 course__detial">
    <p class="box__title">ویراش دوره</p>
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <form action="{{ route('admin.courses.update',$course->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <x-input type="text" name="title" placeholder="عنوان دوره" value="{{$course->title}}" />
                <x-input type="text" class="text-left" name="slug" placeholder="نام انگلیسی دوره" value="{{$course->slug}}" />

                <div class="d-flex multi-text margin-bottom-10">
                    <x-input type="text" class="text-left mlg-15" name="priority" placeholder="ردیف دوره"  value="{{$course->priority}}"/>
                    <x-input type="text" class="text-left mlg-15" name="price" placeholder="مبلغ دوره" value="{{$course->price}}" />
                    <x-input type="number" class="text-left" name="percent" placeholder="درصد مدرس" value="{{$course->percent}}" />
                </div>


                <x-select name="teacher_id" placeholder="انتخاب مدرس دوره">
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}" @if ($course->teacher_id == $teacher->id) selected @endif>{{$teacher->name}}</option>
                    @endforeach
                </x-select>

                <x-tag-select name="tags"/>


                <x-select name="type" placeholder="نوع دوره">
                    @foreach ($types as $type)
                        <option value="{{$type}}" @if ($course->type == $type) selected @endif>@lang($type)</option>
                    @endforeach
                </x-select>


                <x-select name="status" placeholder="وضعیت دوره">
                    @foreach ($statuses as $status)
                        <option value="{{$status}}" @if ($course->status == $status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>


                <x-select name="category_id" placeholder="دسته بندی">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if ($course->category_id == $category->id) selected @endif>
                        {{$category->title}}
                    </option>
                    @endforeach
                </x-select>



                <x-file-upload name="image" placeholder="آپلود بنر دوره" :value="$course->banner" />

                <x-text-area name="body" placeholder="توضیحات دوره" value="{{$course->body}}"/>
                <x-button title="ویراش دوره" />
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
