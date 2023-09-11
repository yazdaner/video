<div class="col-4 bg-white">
    <p class="box__title">ایجاد تخفیف جدید</p>
    <form action="{{ route("admin.discounts.store") }}" method="post" class="padding-30">
        @csrf

        <x-input type="text" placeholder="کد تخفیف" name="code" />
        <x-input type="number" placeholder="درصد تخفیف" name="percent" />
        <x-input type="number" placeholder="محدودیت افراد" name="usage_limitation" />


        <x-input type="text" placeholder="محدودیت زمانی" name="expire_at" class="expireAt"/>




        <p class="box__title">این تخفیف برای</p>
        <x-validation-error field="type"/>
        <div class="notificationGroup">
            <input id="discounts-field-1" class="discounts-field-pn" name="type" value="all" type="radio" />
            <label for="discounts-field-1">همه آیتم ها</label>
        </div>
        <div class="notificationGroup">
            <input id="discounts-field-2" class="discounts-field-pn" name="type" value="special" type="radio" />
            <label for="discounts-field-2">آیتم خاص</label>
        </div>
        <div id="selectCourseContainer" class="d-none">
            <select name="courses[]" class="mySelect2" multiple>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>


        <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" />
        <x-input type="text" name="description" placeholder="توضیحات" class="margin-bottom-15" />



        <button class="btn btn-webamooz_net" type="submit">اضافه کردن</button>
    </form>
</div>
