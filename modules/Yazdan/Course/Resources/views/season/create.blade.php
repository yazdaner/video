<form action="{{route('admin.seasons.store',$course->id)}}" method="post" class="padding-30">
    @csrf
    <x-input type="text" name="title" placeholder="عنوان سرفصل" />
    <x-input type="text" name="number" placeholder="شماره سرفصل" class="text-left" />
    <x-button title="اضافه کردن" />
</form>
