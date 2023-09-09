<div class="col-8 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
    <div class="margin-bottom-20 flex-wrap flex-space-between font-size-14 d-flex bg-white padding-0">
        <p class="mlg-15">{{$course->title}}</p>
        <a class="btn btn-webamooz_net" href="{{route('admin.lessons.create',$course->id)}}">آپلود جلسه جدید</a>
    </div>
    @can(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_MANAGE_COURSES)
    <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
        <button class="btn all-confirm-btn "
            onclick="acceptAllLessons('{{route('admin.lessons.acceptAll',$course->id)}}')">تایید همه جلسات</button>
        <button class="btn delete-btn "
            onclick="rejectAllLessons('{{route('admin.lessons.rejectAll',$course->id)}}')">رد همه جلسات</button>
        <button class="btn confirm-btn" onclick="acceptMultiple('{{route('admin.lessons.acceptedMultiple')}}')">تایید
            جلسات</button>
        <button class="btn reject-btn" onclick="rejectMultiple('{{route('admin.lessons.rejectedMultiple')}}')">رد
            جلسات</button>
        <button class="btn delete-btn" onclick="deleteMultiple('{{route('admin.lessons.destroyMultiple')}}')">حذف
            جلسات</button>
    </div>
    @endcan

    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th style="padding: 13px 30px;">
                        <label class="ui-checkbox">
                            <input type="checkbox" class="checkedAll">
                            <span class="checkmark"></span>
                        </label>
                    </th>
                    <th>شناسه</th>
                    <th>عنوان جلسه</th>
                    <th>عنوان فصل</th>
                    <th>مدت زمان جلسه</th>
                    <th>وضعیت تایید</th>
                    <th>سطح دسترسی</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($lessons as $lesson)
                <tr role="row" data-row-id="{{$lesson->id}}">
                    <td>
                        <label class="ui-checkbox">
                            <input type="checkbox" class="sub-checkbox" data-id="{{$lesson->id}}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><a href="">{{$lesson->priority}}</a></td>
                    <td><a href="">{{$lesson->title}}</a></td>
                    <td>{{$lesson->season->title ?? '-'}}</td>
                    <td>{{$lesson->time ?? '-'}}</td>
                    <td class="confirmation_status"><span
                            class="{{$lesson->ConfirmStatus}}">{{__($lesson->confirmation_status)}}</span></td>
                    <td>{{__($lesson->type)}}</td>
                    <td>
                        <a href="" onclick="deleteItem(event,'{{route('admin.lessons.destroy',$lesson->id)}}')"
                            class="item-delete mlg-10" title="حذف"></a>
                        @can(\Yazdan\RolePermissions\Repositories\PermissionRepository::PERMISSION_MANAGE_COURSES)
                        <a href=""
                            onclick="UpdateConfirmationStatus(event,'{{route('admin.lessons.rejected',$lesson->id)}}','رد شده','آیا از رد این آیتم اطمینان دارید ؟')"
                            class="item-reject mlg-10" title="رد"></a>
                        <a href=""
                            onclick="UpdateConfirmationStatus(event,'{{route('admin.lessons.accepted',$lesson->id)}}','تایید شده','آیا از تایید این آیتم اطمینان دارید ؟')"
                            class="item-confirm mlg-10" title="تایید"></a>
                        @endcan
                        <a href="{{route('admin.lessons.edit',$lesson->id)}}" class="item-edit" title="ویرایش"></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$lessons->links('pagination.admin')}}
</div>
