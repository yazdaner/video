@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="#" title="دوره ها">دوره ها</a></li>
@endsection
@section('content')
<div class="main-content padding-0 courses">
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="courses.html">لیست دوره ها</a>
            <a class="tab__item" href="approved.html">دوره های تایید شده</a>
            <a class="tab__item" href="new-course.html">دوره های تایید نشده</a>
            <a class="tab__item" href="{{route('admin.courses.create')}}">ایجاد دوره جدید</a>
        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" onclick="event.preventDefault();">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text margin-0 search-input__box font-size-13" placeholder="جستجوی دوره">
                    <div class="t-header-search-content " style="display: none;">
                        <input type="text" class="text" placeholder="نام دوره">
                        <input type="text" class="text" placeholder="ردیف">
                        <input type="text" class="text" placeholder="قیمت">
                        <input type="text" class="text" placeholder="نام مدرس">
                        <input type="text" class="text margin-bottom-20" placeholder="دسته بندی">
                        <btutton class="btn btn-webamooz_net">جستجو</btutton>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>ردیف</th>
                            <th>بنر</th>
                            <th>عنوان</th>
                            <th>مدرس دوره</th>
                            <th>قیمت (تومان)</th>
                            <th>وضعیت تایید</th>
                            <th>درصد مدرس</th>
                            <th>وضعیت دوره</th>
                            <th>جزئیات</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $key => $course)
                        <tr role="row" class="">
                            <td><a href="">{{$courses->firstItem() + $key}}</a></td>
                            <td><a href="">{{$course->priority}}</a></td>
                            <td>
                                @if(isset($course->banner_id))
                                <a href="{{$course->banner->thumb()}}" target="_blank"><img
                                        src="{{$course->banner->thumb(60)}}"></a>
                                @endif
                            </td>
                            <td><a href="">{{$course->title}}</a></td>
                            <td><a href="">{{$course->teacher->name}}</a></td>
                            <td>{{number_format($course->price)}}</td>
                            <td class="confirmation_status"><span
                                    class="{{$course->ConfirmStatus}}">{{__($course->confirmation_status)}}</span></td>
                            <td>{{$course->percent}}</td>
                            <td>{{__($course->status)}}</td>
                            <td><a href="{{route('admin.courses.details',$course->id)}}"
                                    class="btn btn-webamooz_net">مشاهده</a></td>
                            <td>
                                @can(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_MANAGE_COURSES)
                                <a href="" onclick="deleteItem(event,'{{route('admin.courses.destroy',$course->id)}}')"
                                    class="item-delete mlg-10" title="حذف"></a>
                                <a href=""
                                    onclick="UpdateConfirmationStatus(event,'{{route('admin.courses.rejected',$course->id)}}','رد شده','آیا از رد این آیتم اطمینان دارید ؟')"
                                    class="item-reject mlg-10" title="رد"></a>
                                <a href=""
                                    onclick="UpdateConfirmationStatus(event,'{{route('admin.courses.accepted',$course->id)}}','تایید شده','آیا از تایید این آیتم اطمینان دارید ؟')"
                                    class="item-confirm mlg-10" title="تایید"></a>
                                @endcan
                                <a href="{{route('admin.courses.edit',$course->id)}}" class="item-edit"
                                    title="ویرایش"></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $courses->links('pagination.admin') }}
        </div>
    </div>
</div>
@endsection
