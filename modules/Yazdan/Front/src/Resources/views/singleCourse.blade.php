@extends('Front::layouts.master')
@section('content')
<main id="single">
    <div class="content">
        <div class="container">
            <article class="article">
                <div class="ads mb-10">
                    <a href="" rel="nofollow noopener"><img src="/img/ads/1440px/test.jpg" alt=""></a>
                </div>
                <div class="h-t">
                    <h1 class="title">{{$course->title}}</h1>
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="/" title="خانه">خانه</a></li>
                            @if ($course->category->parentCategory)
                            <li><a href="{{$course->category->parentCategory->path}}"
                                    title="{{$course->category->parentCategory->title}}">{{$course->category->parentCategory->title}}</a>
                            </li>
                            @endif
                            <li><a href="{{$course->category->path}}"
                                    title="{{$course->category->title}}">{{$course->category->title}}</a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
        <div class="main-row container">
            <div class="sidebar-right">
                <div class="sidebar-sticky">

                    <div class="product-info-box">

                        @if (auth()->check() && auth()->id() == $course->teacher_id)
                        <p class="mycourse ">شما مآیتم این دوره هستید</p>
                        @elseif (auth()->check() && auth()->user()->hasAccessToCourse($course))
                        <p class="mycourse">شما این دوره رو خریداری کرده اید</p>

                        @elseif (auth()->check())
                        <div class="discountBadge">
                            <p>45%</p>
                            تخفیف
                        </div>
                        <div class="sell_course">
                            <strong>قیمت :</strong>
                            <del class="discount-Price">{{number_format($course->price)}}</del>
                            <p class="price">
                                <span class="woocommerce-Price-amount amount">{{number_format($course->finalPrice())}}
                                    <span class="woocommerce-Price-currencySymbol">تومان</span>
                                </span>
                            </p>
                        </div>
                        <button class="btn buy btn-buy">خرید دوره</button>

                        @else
                        <div class="discountBadge">
                            <p>45%</p>
                            تخفیف
                        </div>
                        <div class="sell_course">
                            <strong>قیمت :</strong>
                            <del class="discount-Price">{{number_format($course->price)}}</del>
                            <p class="price">
                                <span class="woocommerce-Price-amount amount">{{number_format($course->finalPrice())}}
                                    <span class="woocommerce-Price-currencySymbol">تومان</span>
                                </span>
                            </p>
                        </div>
                        <a class="btn buy text-white" href="{{route('login')}}">خرید دوره</a>

                        @endif


                        <div class="average-rating-sidebar">
                            <div class="rating-stars">
                                <div class="slider-rating">
                                    <span class="slider-rating-span slider-rating-span-100" data-value="100%"
                                        data-title="خیلی خوب"></span>
                                    <span class="slider-rating-span slider-rating-span-80" data-value="80%"
                                        data-title="خوب"></span>
                                    <span class="slider-rating-span slider-rating-span-60" data-value="60%"
                                        data-title="معمولی"></span>
                                    <span class="slider-rating-span slider-rating-span-40" data-value="40%"
                                        data-title="بد"></span>
                                    <span class="slider-rating-span slider-rating-span-20" data-value="20%"
                                        data-title="خیلی بد"></span>
                                    <div class="star-fill"></div>
                                </div>
                            </div>

                            <div class="average-rating-number">
                                <span class="title-rate title-rate1">امتیاز</span>
                                <div class="schema-stars">
                                    <span class="value-rate text-message"> 4 </span>
                                    <span class="title-rate">از</span>
                                    <span class="value-rate"> 555 </span>
                                    <span class="title-rate">رأی</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="product-info-box">
                        <div class="product-meta-info-list">
                            <div class="total_sales">
                                تعداد دانشجو : <span>{{count($course->students)}}</span>
                            </div>
                            <div class="meta-info-unit one">
                                <span class="title">تعداد جلسات منتشر شده : </span>
                                <span class="vlaue">{{$course->lessonCount}}</span>
                            </div>
                            <div class="meta-info-unit two">
                                <span class="title">مدت زمان دوره تا الان : </span>
                                <span class="vlaue">{{$course->formattedDuration}}</span>
                            </div>
                            <div class="meta-info-unit three">
                                <span class="title">مدت زمان کل دوره : </span>
                                <span class="vlaue">-</span>
                            </div>
                            <div class="meta-info-unit four">
                                <span class="title">مآیتم دوره : </span>
                                <span class="vlaue">{{$course->teacher->name}}</span>
                            </div>
                            <div class="meta-info-unit five">
                                <span class="title">وضعیت دوره : </span>
                                <span class="vlaue">{{__($course->status)}}</span>
                            </div>
                            <div class="meta-info-unit six">
                                <span class="title">پشتیبانی : </span>
                                <span class="vlaue">دارد</span>
                            </div>
                        </div>
                    </div>

                    <div class="course-teacher-details">
                        <div class="top-part">
                            <a href="https://webamooz.net/tutor/mohammadnikoo/">
                                <img alt="{{$course->teacher->name}}" class="img-fluid lazyloaded"
                                    src="{{$course->teacher->getAvatar(60)}}" loading="lazy">
                                <noscript><img class="img-fluid" src="{{$course->teacher->getAvatar(60)}}"
                                        alt="{{$course->teacher->name}}"></noscript>
                            </a>
                            <div class="name">
                                <a href="https://webamooz.net/tutor/mohammadnikoo/" class="btn-link">
                                    <h6>{{$course->teacher->name}}</h6>
                                </a>
                                <span class="job-title">{{$course->teacher->headline}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="short-link">
                        <div class="">
                            <span>لینک دروه</span>
                            <input class="short--link" value="{{$course->path()}}">
                            <a href="" class="short-link-a" data-link="{{$course->path()}}"></a>
                        </div>
                    </div>

                    @include('Front::layouts.sections.sidebar-banners')

                </div>
            </div>
            <div class="content-left">
                @if(isset($lesson->media) && $lesson->media->type == 'video')
                <div class="preview">
                    <video width="100%" controls>
                        <source src="{{$lesson->media->download()}}" type="video/mp4">
                    </video>
                </div>
                @endif
                @if (isset($lesson->media))
                <a href="{{$lesson->media->download()}}" class="episode-download">دانلود این قسمت (قسمت
                    {{$lesson->priority}})</a>
                @endif

                <div class="course-description">
                    <div class="course-description-title">توضیحات دوره</div>

                    {!! $course->body !!}

                    <div class="tags">
                        <ul>
                            <li><a href="">ری اکت</a></li>
                            <li><a href="">reactjs</a></li>
                            <li><a href="">جاوااسکریپت</a></li>
                            <li><a href="">javascript</a></li>
                            <li><a href="">reactjs چیست</a></li>
                        </ul>
                    </div>
                </div>

                @include('Front::layouts.sections.episodes-list')

            </div>
        </div>

    </div>
</main>
<div id="Modal-buy" class="modal">
    <div class="modal-content text-dark">
        <div class="modal-header">
            <p>کد تخفیف را وارد کنید</p>
            <div class="close">&times;</div>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('courses.buy',$course->id)}}">
                @csrf
                <div>
                    <input type="text" name="code" id="code" class="txt" placeholder="کد تخفیف را وارد کنید">
                    <p id="response"></p>
                </div>
                <button type="button" class="btn i-t" onclick="checkDiscountCode()">اعمال
                    <img src="/img/loading.gif" alt="" id="loading" class="loading d-none">
                </button>

                <table class="table tabled text-center table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>قیمت کل دوره</th>
                            <td> {{number_format($course->price)}} تومان</td>
                        </tr>
                        <tr>
                            <th>درصد تخفیف</th>
                            <td>
                                <span id="discountPercent">{{$course->getDiscountPercent()}}</span> %
                            </td>
                        </tr>
                        <tr>
                            <th> مبلغ تخفیف</th>
                            <td class="text-red"><span id="discountAmount">{{number_format($course->getDiscountAmount())}}</span> تومان
                            </td>
                        </tr>
                        <tr>
                            <th> قابل پرداخت</th>
                            <td class="text-green"><span id="payableAmount">
                                {{number_format($course->finalPrice())}}
                                </span> تومان
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn i-t ">پرداخت آنلاین</button>
            </form>
        </div>
    </div>
</div>
<div class="toast">
    <div>
        <div class="toast__icon"></div>
        <div class="toast__message"></div>
        <div class="toast__close" onclick="toast__close()"></div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="/css/modal.css">
@endsection
@section('js')
<script src="/js/modal.js"></script>
<script>
    function checkDiscountCode(){

        const code =  $("#code").val();
        const url = "{{ route("admin.discounts.check", ["code", $course->id]) }}";
        $("#loading").addClass("d-none")
        $("#response").text("")
        $.get(url.replace("code", code))
            .done(function (data) {
                $("#discountPercent").text(data.discountPercent)
                $("#discountAmount").text(data.discountAmount)
                $("#payableAmount").text(data.payableAmount)
                $("#response").text("کد تخفیف با موفقیت اعمال شد.").removeClass("text-red").addClass("text-green")
            })
            .fail(function (data) {
                $("#response").text("کد وارده شده برای این آیتم معتبر نیست.").removeClass("text-green").addClass("text-red")
            })
            .always(function () {
                $("#loading").addClass("d-none")
            });
    }
</script>
@endsection
