<?php

namespace Yazdan\Course\Tests\Feature;

use Tests\TestCase;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\Tests\Helper\CourseHelperTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class CourseTest extends TestCase
{
    use RefreshDatabase,CourseHelperTest;

    // index

    public function testIndexMethod()
    {
        $this->actingAsAdmin();
        $this->get(route('admin.courses.index'))
        ->assertOk();

        $this->actingAsSuperAdmin();
        $this->get(route('admin.courses.index'))
        ->assertOk();
    }

    public function testIndexMethodError()
    {
        $this->actingAsUser();
        $this->get(route('admin.courses.index'))
        ->assertStatus(403);
    }

    // create

    public function testCreateMethod()
    {
        $this->actingAsAdmin();
        $this->get(route('admin.courses.create'))
        ->assertOk();

        $this->actingAsSuperAdmin();
        $this->get(route('admin.courses.create'))
        ->assertOk();

        $this->actingAsCourseOwnPermission();
        $this->get(route('admin.courses.create'))
        ->assertOk();
    }

    public function testCreateMethodError()
    {
        $this->actingAsUser();
        $this->get(route('admin.courses.create'))
        ->assertStatus(403);
    }

    // edit

    public function testEditMethod()
    {

        $this->actingAsAdmin();
        $course = $this->createCourse();
        $this->get(route('admin.courses.edit',$course->id))
        ->assertOk();

        $this->actingAsSuperAdmin();
        $course = $this->createCourse();
        $this->get(route('admin.courses.edit',$course->id))
        ->assertOk();

        $this->actingAsCourseOwnPermission();
        $course = $this->createCourseForTeacher();
        $this->get(route('admin.courses.edit',$course->id))
        ->assertOk();
    }

    public function testEditMethodError()
    {
        $this->actingAsUser();
        $course = $this->createCourse();
        $this->get(route('admin.courses.edit',$course->id))
        ->assertStatus(403);


        $this->actingAsCourseOwnPermission();
        $course = $this->createCourse();
        $this->get(route('admin.courses.edit',$course->id))
        ->assertStatus(403);
    }

    // store

    public function testStoreMethod()
    {
        // admin
        $this->actingAsAdmin();
        $res = $this->storeCourse();
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',1);

        // super admin
        $this->actingAsSuperAdmin();
        $res = $this->storeCourse();
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',2);

        // manage own course permission
        $this->actingAsCourseOwnPermission();
        $res = $this->storeCourse();
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',3);


    }

    public function testStoreMethodError()
    {
        $this->actingAsUser();
        $res = $this->storeCourse();
        $res->assertStatus(403);
        $this->assertDatabaseCount('courses',0);

    }

    // update

    public function testUpdateMethod()
    {
        // admin
        $this->actingAsAdmin();
        $res = $this->updateCourse();
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',1);

        // super admin
        $this->actingAsSuperAdmin();
        $res = $this->updateCourse();
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',2);

        // manage own course permission
        $this->actingAsCourseOwnPermission();

        $course = $this->createCourseForTeacher();
        $data = $this->makeCourse();
        $res = $this->put(route('admin.courses.update',$course->id),$data);
        $res->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseCount('courses',3);
        $this->assertEquals($course->fresh()->title,$data['title']);

    }


    public function testUpdateMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->updateCourse();
        $res->assertStatus(403);

        // manage own course permission
        $this->actingAsCourseOwnPermission();
        $res = $this->updateCourse();
        $res->assertStatus(403);

    }

    // delete

    public function testDestroyMethod()
    {
        // admin
        $this->actingAsAdmin();
        $res = $this->deleteCourse();
        $res->assertOk();
        $this->assertDatabaseCount('courses',0);
    }

    public function testDestroyMethodError()
    {
        // user
        $this->actingAsUser();
        $res = $this->deleteCourse();
        $res->assertStatus(403);
        $this->assertDatabaseCount('courses',1);
    }

    // accept

    public function testAcceptedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $course = $this->createCourse();
        $res = $this->patch(route('admin.courses.accepted',$course->id));
        $res->assertOk();

    }

    public function testAcceptedMethodError()
    {
        // user
        $this->actingAsUser();
        $course = $this->createCourse();
        $res = $this->patch(route('admin.courses.accepted',$course->id));
        $res->assertStatus(403);

    }

    // reject

    public function testRejectedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $course = $this->createCourse();
        $res = $this->patch(route('admin.courses.rejected',$course->id));
        $res->assertOk();

    }

    public function testRejectedMethodError()
    {
        // normal user
        $this->actingAsUser();
        $course = $this->createCourse();
        $res = $this->patch(route('admin.courses.rejected',$course->id));
        $res->assertStatus(403);

    }

    // details

    public function testDetailsMethod()
    {
        // admin
        $this->actingAsAdmin();
        $course = $this->createCourse();
        $res = $this->get(route('admin.courses.details',$course->id));
        $res->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $course = $this->createCourse();
        $res = $this->get(route('admin.courses.details',$course->id));
        $res->assertOk();

        //teacher
        $this->actingAsCourseOwnPermission();

        $course = $this->createCourse();
        $course->teacher_id = auth()->id();
        $course->save();
        $res = $this->get(route('admin.courses.details',$course->id));
        $res->assertOk();
    }

    public function testDetailsMethodError()
    {
        // normal user
        $this->actingAsUser();
        $course = $this->createCourse();
        $res = $this->get(route('admin.courses.details',$course->id));
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $course = $this->createCourse();
        $res = $this->get(route('admin.courses.details',$course->id));
        $res->assertStatus(403);
    }
}
