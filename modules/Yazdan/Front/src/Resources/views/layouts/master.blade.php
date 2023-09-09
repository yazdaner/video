<!doctype html>
<html lang="fa">
@include('Front::layouts.sections.head')

<body>
    @include('Front::layouts.sections.header')

        @yield('content')

    @include('Front::layouts.sections.footer')
    @include('Front::layouts.sections.js')

</body>

</html>
