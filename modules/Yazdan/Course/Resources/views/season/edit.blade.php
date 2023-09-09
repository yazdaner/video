@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('admin.courses.index') }}" title="دوره ها">دوره ها</a></li>
    <li><a href="{{ route('admin.courses.details',$season->course->id) }}" title="جزِییات دوره">جزِییات دوره</a></li>
    <li><a href="#" title="ویرایش سرفصل">ویرایش سرفصل</a></li>
@endsection

@section('content')
<div class="main-content padding-0 course__detial">
    <p class="box__title">ویرایش سرفصل</p>
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <form action="{{ route('admin.seasons.update',$season->id) }}" class="padding-30" method="post">
                @csrf
                @method('patch')
                <x-input type="text" name="title" placeholder="عنوان دوره" value="{{$season->title}}" />
                <x-input type="text" class="text-left" name="number" placeholder="شماره سرفصل" value="{{$season->number}}" />
                <x-button title="ویراش سرفصل" />
            </form>
        </div>
    </div>
</div>
@endsection

