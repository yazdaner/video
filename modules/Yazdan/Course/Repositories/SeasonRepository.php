<?php

namespace Yazdan\Course\Repositories;

use Yazdan\Course\App\Models\Season;

class SeasonRepository
{
    const CONFIRMATION_STATUS_PENDING = 'pending';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_REJECTED];

    public static function findById($id)
    {
        return Season::find($id);
    }

    public static function store($value,$courseId)
    {
        $number = self::generateSeasonNumber($value, $courseId);
        Season::create([
            'course_id' => $courseId,
            'user_id' => auth()->id(),
            'title' => $value->title,
            'number' => $number
        ]);
    }

    public static function update($value,$id)
    {
        $season = static::findById($id);

        $number = self::generateSeasonNumber($value,$season->course->id);

        $season->update([
            'user_id' => auth()->id(),
            'title' => $value->title,
            'number' => $number
        ]);
    }

    public static function updateConfirmationStatus($id,string $status)
    {
        $season = static::findById($id);

        return $season->update([
            'confirmation_status' => $status
        ]);
    }

    public static function generateSeasonNumber($value, $courseId)
    {
        if (is_null($value->number)) {
            $number = CourseRepository::findById($courseId)->seasons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        } else {
            $number = $value->number;
        }
        return $number;
    }

}

