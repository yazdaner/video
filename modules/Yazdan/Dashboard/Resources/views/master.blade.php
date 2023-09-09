<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/panel/css/style.css">
    <link rel="stylesheet" href="/panel/css/responsive_991.css" media="(max-width:991px)">
    <link rel="stylesheet" href="/panel/css/responsive_768.css" media="(max-width:768px)">
    <link rel="stylesheet" href="/panel/css/font.css">
    <link rel="stylesheet" href="/panel/css/jquery.toast.min.css">
    @yield('style')

</head>
<body>
    @include('Dashboard::sections.sidebar')
<div class="content">
    @include('Dashboard::sections.header')

    @include('Dashboard::sections.breadcrumb')
    @yield('content')
</div>

</body>
<script src="/panel/js/jquery-3.4.1.min.js"></script>
<script src="/panel/js/js.js"></script>
<script src="/panel/js/jquery.toast.min.js"></script>
@include('Common::layouts.feedbacks');

@yield('script')

</html>
