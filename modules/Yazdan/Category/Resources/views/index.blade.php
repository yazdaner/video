@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="#" title="دسته بندی ها">دسته بندی ها</a></li>
@endsection
@section('content')
<div class="main-content padding-0 categories">
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">دسته بندی ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام دسته بندی</th>
                            <th>نام انگلیسی دسته بندی</th>
                            <th>دسته پدر</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                            <tr role="row" class="">
                                <td><a href="">{{$categories->firstItem() + $key}}</a></td>
                                <td><a href="">{{$category->title}}</a></td>
                                <td>{{$category->slug}}</td>
                                <td>{{$category->parent}}</td>
                                <td>
                                    <a href="" onclick="deleteItem(event,'{{route('admin.categories.destroy',$category->id)}}')" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="{{route('admin.categories.edit',$category->id)}}" class="item-edit" title="ویرایش"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links('pagination.admin') }}
        </div>
        @include('Category::create')
    </div>
</div>
@endsection
