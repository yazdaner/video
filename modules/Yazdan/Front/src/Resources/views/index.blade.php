@extends('Front::layouts.master')
@section('content')
<main id="index">
<article class="container article">
    @include('Front::layouts.sections.header-ads')
    @include('Front::layouts.sections.top-info')

    @include('Front::layouts.course.latestCourses')
    @include('Front::layouts.course.popularCourses')

</article>
</main>
@include('Front::layouts.sections.latestArticles')
@endsection
