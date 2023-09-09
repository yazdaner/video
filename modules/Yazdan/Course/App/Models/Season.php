<?php

namespace Yazdan\Course\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yazdan\Course\Repositories\SeasonRepository;

class Season extends Model
{
    use HasFactory;

    protected $table = 'seasons';
    protected $guarded = [];

    public function getConfirmStatusAttribute()
    {
        switch ($this->confirmation_status) {
            case SeasonRepository::CONFIRMATION_STATUS_ACCEPTED:
                return 'text-success';
            break;
            case SeasonRepository::CONFIRMATION_STATUS_REJECTED:
                return 'text-error';
            break;
            default:
                return '';
            break;
        }
    }

    public function course()
    {
        return  $this->belongsTo(Course::class,'course_id');
    }
}
