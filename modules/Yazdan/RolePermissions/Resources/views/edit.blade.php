@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('admin.roles.index')}}" title="نقشهای کاربری">نقشهای کاربری</a></li>
    <li><a href="#" title="ویرایش">ویرایش</a></li>
@endsection
@section('content')
    <div class="col-4 bg-white margin-top-30 margin-auto">
        <p class="box__title">ویرایش دسته بندی</p>
        <form action="{{route('admin.roles.update',$role->id)}}" method="post" class="padding-30">
            @csrf
            @method('put')

            <input value="{{$role->name}}" name="name" type="text" placeholder="نام" class="text">

            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror

            <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
            @foreach ($permissions as $permission)
            <label class="ui-checkbox d-inline-block padding-bottom-30">
                <input name="permissions[]" type="checkbox" class="sub-checkbox" value="{{$permission->id}}"
                    @if ($role->hasPermissionTo($permission->id))
                        checked
                    @endif
                >
                <span class="checkmark"></span>
                <span class="margin-right-30 margin-left-10">{{__($permission->name)}}</span>
            </label>
            @endforeach

            @error('permissions')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror

            <button type="submit" class="btn btn-webamooz_net">ویرایش</button>
        </form>
    </div>
@endsection
