@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="#" title="نقش های کاربری">نقش های کاربری</a></li>
@endsection
@section('content')
<div class="main-content padding-0 categories">
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">نقش های کاربری</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام</th>
                            <th>مجوزها</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr role="row" class="">
                                <td>{{$roles->firstItem() + $key}}</td>
                                <td>{{__($role->name)}}</td>
                                <td>
                                    @foreach ($role->permissions as $item)
                                        {{__($item->name)}} <br/>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="" onclick="deleteItem(event,'{{route('admin.roles.destroy',$role->id)}}')" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="{{route('admin.roles.edit',$role->id)}}" class="item-edit" title="ویرایش"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $roles->links('pagination.admin') }}
        </div>
        @include('RolePermissions::create')
    </div>
</div>
@endsection

