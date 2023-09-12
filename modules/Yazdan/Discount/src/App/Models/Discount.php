<?php
namespace Yazdan\Discount\App\Models;

use Yazdan\Course\App\Models\Course;
use Yazdan\Payment\App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $guarded = [];
    protected $casts = [
        "expire_at" => "datetime"
    ];
    public function courses()
    {
        return $this->morphedByMany(Course::class, "discountable");
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, "discount_payment");
    }
}
