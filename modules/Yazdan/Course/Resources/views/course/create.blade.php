@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('admin.courses.index') }}" title="دوره ها">دوره ها</a></li>
    <li><a href="#" title="ایجاد دوره">ایجاد دوره</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد دوره</p>
            <form action="{{ route('admin.courses.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input type="text" name="title" placeholder="عنوان دوره" />
                <x-input type="text" class="text-left" name="slug" placeholder="نام انگلیسی دوره" />

                <div class="d-flex multi-text margin-bottom-10">
                    <x-input type="text" class="text-left mlg-15" name="priority" placeholder="ردیف دوره" />
                    <x-input type="text" class="text-left mlg-15" name="price" placeholder="مبلغ دوره" />
                    <x-input type="number" class="text-left" name="percent" placeholder="درصد مدرس" />
                </div>


                <x-select name="teacher_id" placeholder="انتخاب مدرس دوره">
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}" @if (old('teacher_id') == $teacher->id) selected @endif>{{$teacher->name}}</option>
                    @endforeach
                </x-select>

                <x-tag-select name="tags"/>


                <x-select name="type" placeholder="نوع دوره">
                    @foreach ($types as $type)
                        <option value="{{$type}}" @if (old('type') == $type) selected @endif>@lang($type)</option>
                    @endforeach
                </x-select>


                <x-select name="status" placeholder="وضعیت دوره">
                    @foreach ($statuses as $status)
                        <option value="{{$status}}" @if (old('status') == $status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>


                <x-select name="category_id" placeholder="دسته بندی">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if (old('category_id') == $category->id) selected @endif>
                        {{$category->title}}
                    </option>
                    @endforeach
                </x-select>



                <x-file-upload name="image" placeholder="آپلود بنر دوره" />

                <x-text-area name="body" placeholder="توضیحات دوره" />
                <button class="btn btn-webamooz_net">ایجاد دوره</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
