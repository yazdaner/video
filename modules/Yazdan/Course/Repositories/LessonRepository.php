<?php

namespace Yazdan\Course\Repositories;

use Illuminate\Support\Str;
use Yazdan\Course\App\Models\Lesson;
use Yazdan\Course\App\Models\Season;

class LessonRepository
{

    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const CONFIRMATION_STATUS_PENDING = 'pending';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_REJECTED];


    public static function paginate($value)
    {
        return Lesson::latest()->paginate($value);
    }
    public static function CourseLessonPaginate($courseId,$value)
    {
        return Lesson::where('course_id',$courseId)->latest()->paginate($value);
    }
    public static function findById($id)
    {
        return Lesson::find($id);
    }

    public static function getSeasonsCourse($courseId)
    {
        return Season::where('course_id', $courseId)
            ->where('confirmation_status', SeasonRepository::CONFIRMATION_STATUS_ACCEPTED)
            ->orderByDesc('number')
            ->get();
    }

    public static function findSeasonOfCourse($seasonId, $courseId)
    {
        return Season::where('id',$seasonId)->where('course_id',$courseId)->first();
    }


    public static function store($values,$courseId)
    {
        return Lesson::create([
            'title' => $values->title,
            'slug' =>  $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            'priority' => self::generateSeasonNumber($values->priority,$courseId),
            'type' => $values->type,
            'body' => $values->body,
            'time' => $values->time,
            'season_id' => $values->season_id,
            'course_id' => $courseId,
            'user_id' => auth()->id(),
            'media_id' => $values->media_id,
        ]);
    }

    public static function generateSeasonNumber($priority, $courseId)
    {
        if (is_null($priority)) {
            $number = CourseRepository::findById($courseId)->lessons()->orderBy('priority', 'desc')->firstOrNew([])->priority ?: 0;
            $number++;
        } else {
            $number = $priority;
        }
        return $number;
    }

    public static function updateConfirmationStatus($id,string $status)
    {
        if(is_array($id)){
            return Lesson::whereIn('id',$id)
                ->update(['confirmation_status' => $status]);
        }else{
            $lesson = static::findById($id);
            return $lesson->update([
                'confirmation_status' => $status
            ]);
        }
    }



    public static function update($id,$values)
    {
        $lesson = static::findById($id);

        return $lesson->update([
            'title' => $values->title,
            'slug' =>  $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            'priority' => self::generateSeasonNumber($values->priority,$lesson->course->id),
            'type' => $values->type,
            'body' => $values->body,
            'time' => $values->time,
            'season_id' => $values->season_id,
            'user_id' => auth()->id(),
            'media_id' => $values->media_id,
        ]);
    }

    public static function actionAll($courseId,string $status){
        return Lesson::where('course_id',$courseId)
            ->update(['confirmation_status' => $status]);
    }


}
