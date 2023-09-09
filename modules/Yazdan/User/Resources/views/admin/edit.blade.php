@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('admin.users.index') }}" title="کاربران">کاربران</a></li>
    <li><a href="#" title="ویراش کاربر">ویراش کاربر</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">ویراش کاربر</p>
            <form action="{{ route('admin.users.update',$user->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <x-input type="text" name="name" placeholder="نام" value="{{$user->name}}" />

                <x-input type="email" name="email" placeholder="ایمیل" value="{{$user->email}}" />

                <x-input type="text" name="username" placeholder="نام کاربری" value="{{$user->username}}" />

                <x-input type="text" name="mobile" placeholder="شماره موبایل" value="{{$user->mobile}}" />

                <x-input type="text" name="telegram" placeholder="تلگرام" value="{{$user->telegram}}" />

                <br>

                <x-file-upload name="avatar" placeholder="آپلود عکس کاربر" :value="$user->avatar" />

                <x-select name="status" placeholder="وضعیت کاربر">
                    @foreach ($statuses as $status)
                        <option value="{{$status}}" @if ($user->status == $status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>

                <x-input type="password" name="password" placeholder="پسورد"/>

                <x-input type="text" name="headline" placeholder="عنوان" value="{{$user->headline}}" />

                <x-text-area name="bio" placeholder="درباره" value="{{$user->bio}}"/>

                <button class="btn btn-webamooz_net">ویراش کاربر</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/panel/js/tagsInput.js"></script>
    @include('Common::layouts.feedbacks')
@endsection
