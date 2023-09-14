<?php

namespace Yazdan\Course\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yazdan\Category\App\Models\Category;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Discount\Repositories\DiscountRepository;
use Yazdan\Discount\Services\DiscountService;
use Yazdan\Media\App\Models\Media;
use Yazdan\Payment\App\Models\Payment;
use Yazdan\User\App\Models\User;

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

    // public function getDiscountPercent()
    // {
    //     $discountRepo = new DiscountRepository();
    //     $percent = 0;
    //     $specificDiscount = $discountRepo->getCourseBiggerDiscount($this->id);
    //     if ($specificDiscount) $percent = $specificDiscount->percent;

    //     $globalDiscount = $discountRepo->getGlobalBiggerDiscount();
    //     if ($globalDiscount && $globalDiscount->percent > $percent) $percent = $globalDiscount->percent;
    //     return $percent;
    // }

    public function getDiscount()
    {
        $discountRepo = new DiscountRepository();
        $discount = $discountRepo->getCourseBiggerDiscount($this->id);
        $globalDiscount = $discountRepo->getGlobalBiggerDiscount();
        if ($discount == null && $globalDiscount == null) return null;
        if ($discount == null && $globalDiscount != null) return $globalDiscount;
        if ($discount != null && $globalDiscount == null) return $discount;
        if ($globalDiscount->percent > $discount->percent) return $globalDiscount;
        return $discount;
    }

    public function getDiscountPercent()
    {
        $discount = $this->getDiscount();

        $percent = $discount ? $discount->percent : 0;

        return $percent;
    }


    public function getDiscountAmount($percent = null)
    {
        if ($percent == null) {
            $percent = $this->getDiscountPercent();
        }
        return DiscountService::calculateDiscountAmount($this->price, $percent);
    }



    public function finalPrice($code = null ,$withDiscounts = false)
    {
        $discount = $this->getDiscount();
        $amount = $this->price;

        $discounts = [];
        if ($discount) {
            $discounts [] = $discount;
            $amount = $this->price - $this->getDiscountAmount($discount->percent);
        }

        if ($code) {
            $repo = new DiscountRepository();
            $discountFromCode = $repo->getValidDiscountByCode($code, $this->id);
            if ($discountFromCode) {
                $discounts [] = $discountFromCode;
                $amount = $amount - DiscountService::calculateDiscountAmount($amount, $discountFromCode->percent);
            }
        }

        if ($withDiscounts)
        return [$amount, $discounts];

        return $amount;
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
        return $this->morphMany(Payment::class, "paymentable");
    }
    public function discounts()
    {
        return $this->morphToMany(Discount::class, "discountable");
    }
}
