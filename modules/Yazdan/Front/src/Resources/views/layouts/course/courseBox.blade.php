<div class="col">
    <a href="{{$course->path()}}">
        <div class="course-status">
            {{__($course->status)}}
        </div>
        <div class="discountBadge">
            <p>45%</p>
            تخفیف
        </div>
        <div class="card-img"><img src="{{$course->banner->thumb()}}" alt="reactjs"></div>
        <div class="card-title">
            <h2>{{$course->title}}</h2>
        </div>
        <div class="card-body">
            <img src="{{$course->teacher->getAvatar(60)}}" alt="{{$course->teacher->name}}">
            <span>{{$course->teacher->name}}</span>
        </div>
        <div class="card-details">
            <div class="time">{{$course->formattedDuration}}</div>
            <div class="price">
                <div class="discountPrice">
                    {{number_format($course->price)}}
                </div>
                <div class="endPrice">
                    {{number_format($course->finalPrice())}}
                </div>
            </div>
        </div>
    </a>
</div>
