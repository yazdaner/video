@extends('Home::master')
@section('content')

<div class="user-info bg-white padding-30 font-size-13">
    <x-user-photo />
    <form action="{{route('users.profile')}}" method="POST">
        @csrf
        @method('patch')

        <x-input name="name" type="text" placeholder="نام کاربری" value="{{auth()->user()->name}}"/>
        <x-input name="email" type="text" placeholder="ایمیل" value="{{auth()->user()->email}}" class="text-left" disabled/>

        <x-input name="mobile" type="text" placeholder="شماره موبایل" value="{{auth()->user()->mobile}}" class="text-left"/>

        <x-input name="username" type="text" placeholder="نام کاربری" value="{{auth()->user()->username}}" class="text-left"/>

        <p class="input-help text-left margin-bottom-12" dir="ltr">
            <a href="{{auth()->user()->profilePath()}}">
                {{auth()->user()->profilePath()}}
            </a>
        </p>

        @can(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_TEACH)
            <x-input name="card_number" type="text" placeholder="شماره کارت بانکی" value="{{auth()->user()->card_number}}" class="text-left"/>
            <x-input name="shaba" type="text" placeholder="شماره شبا بانکی" value="{{auth()->user()->shaba}}" class="text-left"/>
            <x-input name="headline" type="text" placeholder="عنوان" value="{{auth()->user()->headline}}"/>
            <x-text-area placeholder="درباره من" name="bio" value="{{auth()->user()->bio}}" />
        @endcan

        <br>
        <button class="btn btn-webamooz_net">ذخیره تغییرات</button>
    </form>
</div>

@endsection

