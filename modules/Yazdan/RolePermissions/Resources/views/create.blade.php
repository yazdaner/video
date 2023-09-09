<div class="col-4 bg-white">
    <p class="box__title">ایجاد نقش کاربری جدید</p>
    <form action="{{route('admin.roles.store')}}" method="post" class="padding-30">
        @csrf
        <input name="name" type="text" placeholder="نام" class="text"
        value="{{old('name')}}">
        @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
        <p class="box__title margin-bottom-15">انتخاب مجوزها</p>

       @foreach ($permissions as $permission)
            <label class="ui-checkbox d-inline-block padding-bottom-30">
                <input name="permissions[]" type="checkbox" class="sub-checkbox" value="{{$permission->id}}"
                    @if (is_array(old('permissions')) && in_array($permission->id,old('permissions')))
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
        <button type="submit" class="btn btn-webamooz_net d-block">اضافه کردن</button>
    </form>
</div>
