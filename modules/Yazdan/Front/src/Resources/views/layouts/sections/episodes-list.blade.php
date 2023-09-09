<div class="episodes-list">
    <div class="episodes-list--title">فهرست جلسات</div>
    <div class="episodes-list-section">

        @foreach ($lessons as $lesson)
            <div class="episodes-list-item {{auth()->check() && auth()->user()->hasAccessToCourse($lesson->course) ? '' : 'lock'}} @if($lesson->slug == request()->lesson) active @endif">
                <div class="section-right">
                    <span class="episodes-list-number">{{$lesson->priority}}</span>
                    <div class="episodes-list-title">
                        <a href="{{$lesson->path()}}">{{$lesson->title}}</a>
                    </div>
                </div>
                <div class="section-left">
                    <div class="episodes-list-details">
                        <div class="episodes-list-details">
                            <span class="detail-type">{{__($lesson->status)}}</span>
                            <span class="detail-time">{{$lesson->time}}</span>
                            <a class="detail-download">
                                <i class="icon-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
