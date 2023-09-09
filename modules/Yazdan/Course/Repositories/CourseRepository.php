<?php

namespace Yazdan\Course\Repositories;

use Illuminate\Support\Str;
use Yazdan\Course\App\Http\Requests\CourseRequest;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\App\Models\Lesson;

class CourseRepository
{
    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];

    const CONFIRMATION_STATUS_PENDING = 'pending';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_REJECTED];

    public static function paginate($value)
    {
        return Course::latest()->paginate($value);
    }
    public static function usersCoursepaginate($userId,$value)
    {
        return Course::where('teacher_id',$userId)->latest()->paginate($value);
    }

    public static function findById($id)
    {
        return Course::find($id);
    }

    public static function findBySlug($slug)
    {
        return Course::where('slug',$slug)->first();
    }

    public static function store($values)
    {
        return Course::create([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,
        ]);
    }

    public static function update($id,$values)
    {
        $course = static::findById($id);

        return $course->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,
        ]);
    }

    public static function updateConfirmationStatus($id,string $status)
    {
        $course = static::findById($id);

        return $course->update([
            'confirmation_status' => $status
        ]);
    }

    public static function latestCourse()
    {
        return Course::where('confirmation_status',CourseRepository::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
    }


    public static function getDuration($id)
    {
        return Lesson::where('course_id',$id)
        ->where('confirmation_status',LessonRepository::CONFIRMATION_STATUS_ACCEPTED)->sum('time');
    }

    public static function getLessonCount($courseId)
    {
        return Lesson::where('course_id',$courseId)
            ->where('confirmation_status',LessonRepository::CONFIRMATION_STATUS_ACCEPTED)->count();
    }

    public static function getLessons($courseId)
    {
        return Lesson::where('course_id',$courseId)
            ->where('confirmation_status',LessonRepository::CONFIRMATION_STATUS_ACCEPTED)->orderBy('priority')->get();
    }

    public static function getFirstLesson($courseId)
    {
        return Lesson::where('course_id',$courseId)
            ->where('confirmation_status',LessonRepository::CONFIRMATION_STATUS_ACCEPTED)->orderBy('priority')->first();
    }
    public static function getLesson($courseId,$lessonSlug)
    {
        return Lesson::where('course_id',$courseId)->where('slug',$lessonSlug)
            ->where('confirmation_status',LessonRepository::CONFIRMATION_STATUS_ACCEPTED)->orderBy('priority')->first();
    }

    public function addStudentToCourse(Course $course,$userId)
    {
        if(! $this->getCourseStudentById($course,$userId)){
            $course->students()->attach($userId);
        }
    }

    public function getCourseStudentById(Course $course,$userId)
    {
        return $course->students()->where('id',$userId)->first();
    }

}



