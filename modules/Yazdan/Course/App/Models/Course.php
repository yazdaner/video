<?php

namespace Yazdan\Course\App\Models;

use Yazdan\User\App\Models\User;
use Yazdan\Media\App\Models\Media;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Yazdan\Media\Services\ImageFileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yazdan\Category\App\Models\Category;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Payment\App\Models\Payment;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $guarded = [];

    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getConfirmStatusAttribute()
    {
        switch ($this->confirmation_status) {
            case CourseRepository::CONFIRMATION_STATUS_ACCEPTED:
                return 'text-success';
                break;
            case CourseRepository::CONFIRMATION_STATUS_REJECTED:
                return 'text-error';
                break;
            default:
                return '';
                break;
        }
    }

    public function discountAmount()
    {
        // todo
        return 0;
    }

    public function DiscountPercent()
    {
        // todo
        return 0;
    }

    public function finalPrice()
    {
        return $this->price - $this->discountAmount();
    }

    public function getFormattedDurationAttribute()
    {
        $duration = CourseRepository::getDuration($this->id);
        $h = intdiv($duration, 60) < 10 ? '0' . intdiv($duration, 60) : intdiv($duration, 60);
        $m = ($duration % 60) < 10 ? '0' . ($duration % 60) : ($duration % 60);
        return $h . ':' . $m . ':00';
    }

    public function path()
    {
        return route('singleCourse', $this->slug);
    }

    public function getLessonCountAttribute()
    {
        return CourseRepository::getLessonCount($this->id);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class,'paymentable');
    }

}
