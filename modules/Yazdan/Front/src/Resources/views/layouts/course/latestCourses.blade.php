<div class="box-filter">
    <div class="b-head">
        <h2>جدید ترین دوره ها</h2>
        <a href="all-courses.html">مشاهده همه</a>
    </div>
    <div class="posts">

        @foreach ($latestCourses as $course)

            @include('Front::layouts.course.courseBox')

        @endforeach

    </div>
</div>
