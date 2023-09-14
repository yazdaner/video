<?php

namespace Yazdan\Course\Tests\Helper;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Yazdan\Category\App\Models\Category;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\App\Models\Lesson;
use Yazdan\Course\App\Models\Season;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Course\Repositories\LessonRepository;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\RolePermissions\Database\Seeders\RolePermissionsSeeder;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;


trait CourseHelperTest
{
    use WithFaker;

    // User

    public function createUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionsSeeder::class);
    }

    public function actingAsCourseOwnPermission()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES);
    }

    public function actingAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }

    public function actingAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN);
    }

    public function actingAsUser()
    {
        return $this->createUser();
    }

    // Course

    public function createCourse()
    {
        Storage::fake('local');
        return Course::factory()->create();
    }

    public function makeCourse()
    {
        Storage::fake('local');
        return [
            "title" =>  $this->faker->title(),
            "slug" => $this->faker->slug(),
            "priority" => random_int(1, 100),
            "price" => random_int(10000, 1000000),
            "percent" => random_int(1, 100),
            "teacher_id" => User::factory()->create()->assignRole('teacher')->id,
            "type" => collect(CourseRepository::$types)->random(),
            "status" => collect(CourseRepository::$statuses)->random(),
            "category_id" => Category::factory()->create()->id,
            "body" => $this->faker->text(),
            'image' => UploadedFile::fake()->image(uniqid() . '.png')
        ];
    }

    public function storeCourse()
    {
        $course = $this->makeCourse();
        return $this->post(route('admin.courses.store'), $course);
    }


    public function deleteCourse()
    {
        $course = $this->createCourse();
        return $this->delete(route('admin.courses.destroy', $course->id));
    }

    public function updateCourse()
    {
        $course = $this->createCourse();
        $data = $this->makeCourse();
        return $this->put(route('admin.courses.update', $course->id), $data);
    }

    // Season

    public function makeSeason()
    {
        return [
            'title' => $this->faker->title(),
            'number' => $this->faker->numberBetween(1, 250)
        ];
    }

    public function storeSeason()
    {
        $course = $this->CreateCourse();
        return $this->post(route('admin.seasons.store', $course->id), $this->makeSeason());
    }

    public function createSeason()
    {
        $course = $this->createCourse();
        $season = Season::create([
            'user_id' => $course->teacher_id,
            'course_id' => $course->id,
            'title' => $this->faker->title(),
            'number' => $this->faker->numberBetween(1, 250)
        ]);
        return $season;
    }

    public function updateSeason()
    {
        $season = $this->createSeason();
        $data = $this->makeSeason();
        return $this->patch(route('admin.seasons.update', $season->id), $data);
    }

    public function deleteSeason()
    {
        $season = $this->createSeason();
        return $this->delete(route('admin.seasons.destroy', $season->id));
    }

    public function createCourseForTeacher()
    {
        Storage::fake('local');
        return Course::factory()->state(['teacher_id' => auth()->id()])->create();
    }

    public function createSeasonForTeacher()
    {
        $this->actingAsCourseOwnPermission();
        $course = $this->createCourseForTeacher();
        return Season::create([
            'user_id' => $course->teacher_id,
            'course_id' => $course->id,
            'title' => $this->faker->title(),
            'number' => $this->faker->numberBetween(1, 250)
        ]);
    }

    // lesson

    public function makeLesson()
    {
        Storage::fake('local');
        return [
            "title" =>  $this->faker->title(),
            "slug" => $this->faker->slug(),
            "priority" => random_int(1, 100),
            "time" => random_int(1, 100),
            "body" => $this->faker->text(),
            "type" => collect(LessonRepository::$types)->random(),
            "confirmation_status" => collect(LessonRepository::$confirmationStatuses)->random(),
            'lesson_file' => UploadedFile::fake()->create(uniqid() . '.mp4', 10240)
        ];
    }

    public function storeLesson()
    {
        $course = $this->createCourse();
        return $this->post(route('admin.lessons.store', $course->id), $this->makeLesson());
    }

    public function createLesson()
    {
        Storage::fake('local');
        $course = $this->createCourse();
        $lesson = Lesson::create([
            'user_id' => $course->teacher_id,
            'course_id' => $course->id,
            "title" =>  $this->faker->title(),
            "slug" => $this->faker->slug(),
            "priority" => random_int(1, 100),
            "time" => random_int(1, 100),
            "body" => $this->faker->text(),
            "type" => collect(LessonRepository::$types)->random(),
            "confirmation_status" => collect(LessonRepository::$confirmationStatuses)->random(),
            'media_id' => MediaFileService::privateUpload(UploadedFile::fake()->create(uniqid() . '.mp4', 10240))->id
        ]);
        return $lesson;
    }

    public function createLessonForTeacher()
    {
        $this->actingAsCourseOwnPermission();
        $course = $this->createCourseForTeacher();
        return Lesson::create([
            'user_id' => $course->teacher_id,
            'course_id' => $course->id,
            "title" =>  $this->faker->title(),
            "slug" => $this->faker->slug(),
            "priority" => random_int(1, 100),
            "time" => random_int(1, 100),
            "body" => $this->faker->text(),
            "type" => collect(LessonRepository::$types)->random(),
            "confirmation_status" => collect(LessonRepository::$confirmationStatuses)->random(),
            'media_id' => MediaFileService::privateUpload(UploadedFile::fake()->create(uniqid() . '.mp4', 10240))->id

        ]);
    }


    public function updateLesson()
    {
        $lesson = $this->createLesson();
        $data = $this->makeLesson();
        return $this->put(route('admin.lessons.update', $lesson->id), $data);
    }

    public function deleteLesson()
    {
        $lesson = $this->createLesson();
        return $this->delete(route('admin.lessons.destroy', $lesson->id));
    }


    public function createSomeLessonForCourse($count, $hasTeacher = false, $getCourse = false)
    {
        if ($hasTeacher) {
            $course = $this->createCourseForTeacher();
        } else {
            $course = $this->createCourse();
        }

        $lessons = [];
        for ($i = 0; $i < $count; $i++) {
            $lessons[$i] = Lesson::create([
                'user_id' => $course->teacher_id,
                'course_id' => $course->id,
                "title" =>  $this->faker->title(),
                "slug" => $this->faker->slug(),
                "priority" => random_int(1, 100),
                "time" => random_int(1, 100),
                "body" => $this->faker->text(),
                "type" => collect(LessonRepository::$types)->random(),
                'media_id' => MediaFileService::privateUpload(UploadedFile::fake()->create(uniqid() . '.mp4', 10240))->id
            ])->id;
        }

        if ($getCourse) {
            return $course;
        } else {
            return $lessons;
        }
    }
}
