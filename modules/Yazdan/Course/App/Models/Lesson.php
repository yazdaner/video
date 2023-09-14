<?php

namespace Yazdan\Course\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yazdan\Course\Repositories\LessonRepository;
use Yazdan\Media\App\Models\Media;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $guarded = [];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function getConfirmStatusAttribute()
    {
        switch ($this->confirmation_status) {
            case LessonRepository::CONFIRMATION_STATUS_ACCEPTED:
                return 'text-success';
                break;
            case LessonRepository::CONFIRMATION_STATUS_REJECTED:
                return 'text-error';
                break;
            default:
                return '';
                break;
        }
    }

    public function path()
    {
        return $this->course->path() . '?lesson=' . $this->slug;
    }
}
