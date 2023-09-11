<?php
namespace Yazdan\Discount\App\Models;

use Yazdan\Course\App\Models\Course;
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
}
