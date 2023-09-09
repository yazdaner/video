<div class="col-12 bg-white margin-bottom-15 border-radius-3">
    <p class="box__title">سرفصل ها</p>
    @include('Season::create')
    <div class="table__box padding-30">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th class="p-r-90">شماره فصل</th>
                <th>عنوان فصل</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($course->seasons->sortByDesc('number') as $season)
                <tr role="row" class="">
                    <td><a href="">{{$season->number}}</a></td>
                    <td><a href="">{{$season->title}}</a></td>
                    <td class="confirmation_status"><span class="{{$season->ConfirmStatus}}">{{__($season->confirmation_status)}}</span></td>
                    <td>
                        <a href="" onclick="deleteItem(event,'{{route('admin.seasons.destroy',$season->id)}}')" class="item-delete mlg-10" title="حذف"></a>
                        <a href="{{route('admin.seasons.edit',$season->id)}}" class="item-edit mlg-10" title="ویرایش"></a>
                        @can(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_MANAGE_COURSES)
                            <a href="" onclick="UpdateConfirmationStatus(event,'{{route('admin.seasons.rejected',$season->id)}}','رد شده','آیا از رد این آیتم اطمینان دارید ؟')" class="item-reject mlg-10" title="رد"></a>
                            <a href="" onclick="UpdateConfirmationStatus(event,'{{route('admin.seasons.accepted',$season->id)}}','تایید شده','آیا از تایید این آیتم اطمینان دارید ؟')" class="item-confirm mlg-10" title="تایید"></a>
                        @endcan

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
