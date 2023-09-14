<?php

namespace Yazdan\Course\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Yazdan\Course\App\Models\Lesson;
use Yazdan\Course\Repositories\LessonRepository;
use Yazdan\Course\Tests\Helper\CourseHelperTest;

class LessonTest extends TestCase
{
    use RefreshDatabase, CourseHelperTest;

    // create

    public function testCreateMethod()
    {
        // admin
        $this->actingAsAdmin();
        $course = $this->createCourse();
        $this->get(route('admin.lessons.create', $course->id))
            ->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $course = $this->createCourse();
        $this->get(route('admin.lessons.create', $course->id))
            ->assertOk();

        // teacher
        $this->actingAsCourseOwnPermission();
        $course = $this->createCourseForTeacher();
        $this->get(route('admin.lessons.create', $course->id))
            ->assertOk();
    }

    public function testCreateMethodError()
    {
        // normal user
        $this->actingAsUser();
        $course = $this->createCourse();
        $this->get(route('admin.lessons.create', $course->id))
            ->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $course = $this->createCourse();
        $this->get(route('admin.lessons.create', $course->id))
            ->assertStatus(403);
    }

    // store

    public function testStoreMethod()
    {
        // admin
        $this->actingAsAdmin();
        $this->storeLesson();
        $this->assertDatabaseCount('lessons', 1);

        // super admin
        $this->actingAsSuperAdmin();
        $this->storeLesson();
        $this->assertDatabaseCount('lessons', 2);

        // teacher
        $this->actingAsCourseOwnPermission();
        $course = $this->CreateCourse();
        $course->teacher_id  = auth()->user()->id;
        $course->save();
        $this->post(route('admin.lessons.store', $course->id), $this->makeLesson());
        $this->assertDatabaseCount('lessons', 3);
    }

    public function testStoreMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->storeLesson();
        $res->assertStatus(403);
        $this->assertDatabaseCount('lessons', 0);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $res = $this->storeLesson();
        $res->assertStatus(403);
        $this->assertDatabaseCount('lessons', 0);
    }

    public function testStoreMethodValidExtention()
    {
        $validExtentions = ['mkv', 'mp4', 'zip'];
        Storage::fake('local');
        $this->actingAsAdmin();
        $course = $this->createCourse();
        foreach ($validExtentions as $validExtention) {
            $this->post(route('admin.lessons.store', $course->id), [
                "title" =>  $this->faker->title(),
                "slug" => $this->faker->slug(),
                "priority" => random_int(1, 100),
                "time" => random_int(1, 100),
                "body" => $this->faker->text(),
                "type" => collect(LessonRepository::$types)->random(),
                "confirmation_status" => collect(LessonRepository::$confirmationStatuses)->random(),
                'lesson_file' => UploadedFile::fake()->create(uniqid() . '.' . $validExtention, 10240)
            ]);
        }
        $this->assertDatabaseCount('lessons', count($validExtentions));
    }

    public function testStoreMethodErrorInvalidExtention()
    {
        $invalidExtentions = ['png', 'jpg', 'mp3'];
        Storage::fake('local');
        $this->actingAsAdmin();
        $course = $this->createCourse();
        foreach ($invalidExtentions as $invalidExtention) {
            $this->post(route('admin.lessons.store', $course->id), [
                "title" =>  $this->faker->title(),
                "slug" => $this->faker->slug(),
                "priority" => random_int(1, 100),
                "time" => random_int(1, 100),
                "body" => $this->faker->text(),
                "type" => collect(LessonRepository::$types)->random(),
                "confirmation_status" => collect(LessonRepository::$confirmationStatuses)->random(),
                'lesson_file' => UploadedFile::fake()->create(uniqid() . '.' . $invalidExtention, 10240)
            ]);
        }
        $this->assertDatabaseCount('lessons', 0);
    }

    // edit

    public function testEditMethod()
    {
        // admin
        $this->actingAsAdmin();
        $lesson = $this->createLesson();
        $this->get(route('admin.lessons.edit', $lesson->id))
            ->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $lesson = $this->createLesson();
        $this->get(route('admin.lessons.edit', $lesson->id))
            ->assertOk();

        // teacher
        $lesson = $this->createLessonForTeacher();
        $this->get(route('admin.lessons.edit', $lesson->id))
            ->assertOk();
    }

    public function testEditMethodError()
    {
        // normal user
        $this->actingAsUser();
        $lesson = $this->createLesson();
        $this->get(route('admin.lessons.edit', $lesson->id))
            ->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $lesson = $this->createLesson();
        $this->get(route('admin.lessons.edit', $lesson->id))
            ->assertStatus(403);
    }

    // update

    public function testUpdateMethod()
    {
        // admin
        $this->actingAsAdmin();
        $this->updateLesson();
        $this->assertDatabaseCount('lessons', 1);

        // super admin
        $this->actingAsSuperAdmin();
        $this->updateLesson();
        $this->assertDatabaseCount('lessons', 2);

        // teacher
        $lesson = $this->createLessonForTeacher();
        $data = $this->makeLesson();
        $this->put(route('admin.lessons.update', $lesson->id), $data);
        $this->assertDatabaseCount('lessons', 3);
        $this->assertEquals($lesson->fresh()->title, $data['title']);
    }

    public function testUpdateMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->updateLesson();
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $res = $this->updateLesson();
        $res->assertStatus(403);
    }

    // delete

    public function testDestroyMethod()
    {
        // admin
        $this->actingAsAdmin();
        $res = $this->deleteLesson();
        $res->assertOk();
        $this->assertDatabaseCount('lessons', 0);

        // super admin
        $this->actingAsSuperAdmin();
        $res = $this->deleteLesson();
        $res->assertOk();
        $this->assertDatabaseCount('lessons', 0);

        // teacher
        $lesson = $this->createLessonForTeacher();
        $res = $this->delete(route('admin.lessons.destroy', $lesson->id));
        $res->assertOk();
        $this->assertDatabaseCount('lessons', 0);
    }

    public function testDestroyMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->deleteLesson();
        $res->assertStatus(403);
        $this->assertDatabaseCount('lessons', 1);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $res = $this->deleteLesson();
        $res->assertStatus(403);
        $this->assertDatabaseCount('lessons', 2);
    }

    // accept

    public function testAcceptedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.accepted', $lesson->id));
        $res->assertOk();
        $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);

        // super admin
        $this->actingAsSuperAdmin();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.accepted', $lesson->id));
        $res->assertOk();
        $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(2)->confirmation_status);
    }

    public function testAcceptedMethodError()
    {
        // normal user
        $this->actingAsUser();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.accepted', $lesson->id));
        $res->assertStatus(403);

        // teacher
        $lesson = $this->createLessonForTeacher();
        $res = $this->patch(route('admin.lessons.accepted', $lesson->id));
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.accepted', $lesson->id));
        $res->assertStatus(403);
    }

    // accepted Multiple
    public function testAcceptedMultipleMethod()
    {
        // admin
        $this->actingAsAdmin();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.acceptedMultiple'), ['ids' => $lessonsId]);
        $res->assertOk();
        foreach ($lessonsId as $key => $value) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lessonsId[$key])->confirmation_status);
        }


        // super admin
        $this->actingAsSuperAdmin();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.acceptedMultiple'), ['ids' => $lessonsId]);
        $res->assertOk();
        foreach ($lessonsId as $key => $value) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lessonsId[$key])->confirmation_status);
        }
    }

    public function testAcceptedMultipleMethodError()
    {
        // normal user
        $this->actingAsUser();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.acceptedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }

        // teacher
        $this->actingAsCourseOwnPermission();
        $lessonsId = $this->createSomeLessonForCourse(2, true);
        $res = $this->patch(route('admin.lessons.acceptedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.acceptedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }
    }


    // accept All

    public function testAcceptAllMethod()
    {

        // admin
        $this->actingAsAdmin();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.acceptAll', $course->id));
        $res->assertOk();
        foreach ($course->lessons as $lesson) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lesson->id)->confirmation_status);
        }


        // super admin
        $this->actingAsSuperAdmin();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.acceptAll', $course->id));
        $res->assertOk();
        foreach ($course->lessons as $lesson) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lesson->id)->confirmation_status);
        }
    }

    public function testAcceptAllMethodError()
    {
        // normal user
        $this->actingAsUser();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.acceptAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }


        // teacher
        $this->actingAsCourseOwnPermission();
        $course = $this->createSomeLessonForCourse(2, true, true);
        $res = $this->patch(route('admin.lessons.acceptAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.acceptAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_ACCEPTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }
    }

    // reject

    public function testRejectedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.rejected', $lesson->id));
        $res->assertOk();
        $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);

        // super admin
        $this->actingAsSuperAdmin();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.rejected', $lesson->id));
        $res->assertOk();
        $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find(2)->confirmation_status);
    }

    public function testRejectedMethodError()
    {
        // normal user
        $this->actingAsUser();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.rejected', $lesson->id));
        $res->assertStatus(403);

        // teacher
        $lesson = $this->createLessonForTeacher();
        $res = $this->patch(route('admin.lessons.rejected', $lesson->id));
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $lesson = $this->createLesson();
        $res = $this->patch(route('admin.lessons.rejected', $lesson->id));
        $res->assertStatus(403);
    }

    // rejected Multiple
    public function testRejectedMultipleMethod()
    {
        // admin
        $this->actingAsAdmin();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.rejectedMultiple'), ['ids' => $lessonsId]);
        $res->assertOk();
        foreach ($lessonsId as $key => $value) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lessonsId[$key])->confirmation_status);
        }


        // super admin
        $this->actingAsSuperAdmin();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.rejectedMultiple'), ['ids' => $lessonsId]);
        $res->assertOk();
        foreach ($lessonsId as $key => $value) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lessonsId[$key])->confirmation_status);
        }
    }

    public function testRejectedMultipleMethodError()
    {
        // normal user
        $this->actingAsUser();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.rejectedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }

        // teacher
        $this->actingAsCourseOwnPermission();
        $lessonsId = $this->createSomeLessonForCourse(2, true);
        $res = $this->patch(route('admin.lessons.rejectedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $lessonsId = $this->createSomeLessonForCourse(2);
        $res = $this->patch(route('admin.lessons.rejectedMultiple'), ['ids' => $lessonsId]);
        $res->assertStatus(403);
        foreach ($lessonsId as $key => $value) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lessonsId[$key])->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lessonsId[$key])->confirmation_status);
        }
    }

    // reject All

    public function testRejectAllMethod()
    {

        // admin
        $this->actingAsAdmin();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.rejectAll', $course->id));
        $res->assertOk();
        foreach ($course->lessons as $lesson) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lesson->id)->confirmation_status);
        }


        // super admin
        $this->actingAsSuperAdmin();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.rejectAll', $course->id));
        $res->assertOk();
        foreach ($course->lessons as $lesson) {
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lesson->id)->confirmation_status);
        }
    }

    public function testRejectAllMethodError()
    {
        // normal user
        $this->actingAsUser();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.rejectAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }


        // teacher
        $this->actingAsCourseOwnPermission();
        $course = $this->createSomeLessonForCourse(2, true, true);
        $res = $this->patch(route('admin.lessons.rejectAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $course = $this->createSomeLessonForCourse(2, false, true);
        $res = $this->patch(route('admin.lessons.rejectAll', $course->id));
        $res->assertStatus(403);
        foreach ($course->lessons as $lesson) {
            $this->assertNotEquals(LessonRepository::CONFIRMATION_STATUS_REJECTED, Lesson::find($lesson->id)->confirmation_status);
            $this->assertEquals(LessonRepository::CONFIRMATION_STATUS_PENDING, Lesson::find($lesson->id)->confirmation_status);
        }
    }
}
