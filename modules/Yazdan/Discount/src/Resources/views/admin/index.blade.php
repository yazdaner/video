@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="{{ route('admin.discounts.index') }}" title="تخفیف ها">تخفیف ها</a></li>
@endsection
@section("content")
<div class="main-content padding-0 discounts">
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">تخفیف ها</p>
            <div class="table__box">
                <div class="table-box">
                    <table class="table">
                        <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>کد تخفیف</th>
                                <th>درصد</th>
                                <th>نوع</th>
                                <th>محدودیت زمانی</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                            <tr role="row" class="">
                                <td><a href="">{{ $discount->code }}</a></td>
                                <td><a href="">{{ $discount->percent }}%</a></td>
                                <td>@lang($discount->type)</td>
                                <td>{{ $discount->expire_at ? Carbon\Carbon::parse( $discount->expire_at
                                    )->diffForHumans() : '-' }}</td>
                                <td>{{ $discount->uses }} نفر</td>
                                <td>
                                    <a href="" onclick="deleteItem(event, '{{ route('admin.discounts.destroy', $discount->id) }}')" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="{{route('admin.discounts.edit',$discount->id)}}" class="item-edit"
                                        title="ویرایش"></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('Discount::admin.create')
    </div>
</div>

@endsection

@section('style')
<link rel="stylesheet" href="/panel/css/persian-datepicker.min.css" />
@endsection

@section('script')
<script src="/panel/js/persian-date.min.js"></script>
<script src="/panel/js/persian-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('.expireAt').persianDatepicker({
        initialValue: false,
        observer: true,
        format: 'YYYY/MM/DD hh:mm',
        timePicker: {
        enabled: true,
        meridiem: {
            enabled: true
        }
    },
    onSelect: function (params) {
            valOf = $(this.model.inputElement).val();
            $(this.model.inputElement).val(valOf.toEnglishDigits());
        }
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.mySelect2').select2({
        placeholder: "یک یا چند آیتم را انتخاب کنید...",
        dir: "rtl",
    });
</script>
@endsection
