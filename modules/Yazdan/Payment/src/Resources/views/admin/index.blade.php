@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="#" title="تراکنش ها">تراکنش ها</a></li>
@endsection
@section('content')



<div class="main-content padding-0 payments">


    <div class="row no-gutters  margin-bottom-10">

        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>کل فروش سایت</p>
            <p>{{number_format($totalSell)}} تومان</p>
        </div>

        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> فروش ۳۰ روز گذشته سایت </p>
            <p>{{number_format($last30DaysTotal)}} تومان</p>
        </div>

        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> فروش امروز سایت </p>
            <p>{{number_format($todaySell)}} تومان</p>
        </div>

        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p> فروش این هفته سایت </p>
            <p>{{number_format($thisWeekSell)}} تومان</p>
        </div>

    </div>


    <div class="row no-gutters border-radius-3 font-size-13">
        <div class="col-12 bg-white padding-30 margin-bottom-20">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>

    </div>


    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
       <a class="btn btn-webamooz_net" href="{{route('admin.payments.index')}}">همه تراکنش ها</a>
        <div class="t-header-search">
            <form>
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی تراکنش">
                    <div class="t-header-search-content " style="display: none;">
                        <input type="text"  class="text" name="email" value="{{ request("email") }}"  placeholder="ایمیل">
                        <input type="text"  class="text" name="amount"  value="{{ request("amount") }}" placeholder="مبلغ به تومان">
                        <input type="text"  class="text" name="invoice_id" value="{{ request("invoice_id") }}" placeholder="شماره تراکنش">
                        <input type="text"  class="text" name="start_date" value="{{ request("start_date") }}" placeholder="از تاریخ : 1402/6/18">
                        <input type="text" class="text margin-bottom-20" name="end_date" value="{{ request("end_date") }}"  placeholder="تا تاریخ : 1402/6/18">
                        <button class="btn btn-webamooz_net" type="submit">جستجو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">تراکنش ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام کاربر</th>
                            <th>ایمیل کاربر</th>
                            <th>نام محصول</th>
                            <th>مبلغ (تومان)</th>
                            <th>شناسه تراکنش</th>
                            <th>تاریخ</th>
                            <th>وضعیت تراکنش</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                        <tr role="row" class="">
                            <td>{{$payments->firstItem() + $key}}</td>

                            <td>{{$payment->user->name}}</td>
                            <td>{{$payment->user->email}}</td>
                            <td>{{$payment->paymentable->title}}</td>
                            <td>{{number_format($payment->amount)}}</td>
                            <td>{{$payment->invoice_id}}</td>
                            <td>{{$payment->created_at}}</td>
                            <td class="{{$payment->confirmStatus}}">{{__($payment->status)}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
            {{ $payments->links('pagination.admin') }}
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    let query = [@foreach($dates as $date => $value) @if($day = $successSummery->where("date", $date)->first()) {{ $day->totalAmount }}, @else 0, @endif @endforeach];
    Highcharts.chart('container', {
    title: {
            text: 'نمودار فروش 30 روز گذشته'
        },
    tooltip :{
        useHTML : true,
        style : {
            fontSize : '20px',
            fontFamily : 'tahoma',
            direction : 'rtl',
        },
        formatter : function(){
            return (this.x ? "تاریخ: " +  this.x + "<br>" : "")  + "مبلغ: " + number_format(this.y) + ' تومان'

        }

    },
    xAxis: {
        categories: [@foreach ($last30Days as $day)"{{getJalaliFromFormat($day->format('Y/m/d'))}}", @endforeach]
    },
    yAxis: {
        title: {
            text: 'مبلغ'
        },
        labels : {
            formatter : function(){
                return this.value + 'تومان'
            }
        }
    },
    labels: {
                items: [{
                    html: 'درامد 30 روز گذشته',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },

    plotOptions: {
        series: {
            borderRadius: '25%'
        }
    },
    series: [{
        type: 'column',
        name: 'تراکنش موفق',
        data: query

    },
    {
        type: 'column',
        name: 'تراکنش ناموفق',
        data: [@foreach($dates as $date => $value) @if($day = $failSummery->where("date", $date)->first()) {{ $day->totalAmount }}, @else 0, @endif @endforeach]
    },{
        type: 'spline',
        name: 'فروش',
        data: query,
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    },{
        type: 'pie',
        name: 'Total',
        data: [{
            name: 'تراکنش موفق',
            y: {{ $paymentRepository->getAllSuccessTotal() }},
            color: Highcharts.getOptions().colors[0],

        }, {
            name: 'تراکنش ناموفق',
            y: {{ $paymentRepository->getAllFailTotal() }},
            color: Highcharts.getOptions().colors[1]
        }],
        center: [75, 65],
        size: 100,
        innerSize: '70%',
        showInLegend: false,
        dataLabels: {
            enabled: false
        }
    }
]
});

</script>
@endsection
