<?php

namespace Yazdan\Course\Tests\Feature;

use Tests\TestCase;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\Tests\Helper\CourseHelperTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Yazdan\Course\App\Models\Season;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class SeasonTest extends TestCase
{
    use RefreshDatabase, CourseHelperTest;

    // store

    public function testStoreMethod()
    {
        // admin
        $this->actingAsAdmin();
        $this->storeSeason();
        $this->assertDatabaseCount('seasons', 1);

        // super admin
        $this->actingAsSuperAdmin();
        $this->storeSeason();
        $this->assertDatabaseCount('seasons', 2);

        // teacher
        $this->actingAsCourseOwnPermission();
        $course = $this->CreateCourse();
        $course->teacher_id  = auth()->user()->id;
        $course->save();
        $this->post(route('admin.seasons.store', $course->id),$this->makeSeason());
        $this->assertDatabaseCount('seasons', 3);
    }

    public function testStoreMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->storeSeason();
        $res->assertStatus(403);
        $this->assertDatabaseCount('seasons', 0);

        //teacher of other courses

        $this->actingAsCourseOwnPermission();
        $res = $this->storeSeason();
        $res->assertStatus(403);
        $this->assertDatabaseCount('seasons', 0);
    }

    // edit

    public function testEditMethod()
    {
        // admin
        $this->actingAsAdmin();
        $season = $this->createSeason();
        $this->get(route('admin.seasons.edit', $season->id))
            ->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $season = $this->createSeason();
        $this->get(route('admin.seasons.edit', $season->id))
            ->assertOk();

        // teacher
        $season = $this->createSeasonForTeacher();
        $this->get(route('admin.seasons.edit', $season->id))
            ->assertOk();
    }

    public function testEditMethodError()
    {
        // normal user
        $this->actingAsUser();
        $season = $this->createSeason();
        $this->get(route('admin.seasons.edit', $season->id))
            ->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $season = $this->createSeason();
        $this->get(route('admin.seasons.edit', $season->id))
            ->assertStatus(403);
    }

    // update

    public function testUpdateMethod()
    {
        // admin
        $this->actingAsAdmin();
        $this->updateSeason();
        $this->assertDatabaseCount('seasons', 1);

        // super admin
        $this->actingAsSuperAdmin();
        $this->updateSeason();
        $this->assertDatabaseCount('seasons', 2);

        // teacher
        $season = $this->createSeasonForTeacher();
        $data = $this->makeSeason();
        $this->patch(route('admin.seasons.update', $season->id), $data);
        $this->assertDatabaseCount('seasons', 3);
        $this->assertEquals($season->fresh()->title, $data['title']);
    }

    public function testUpdateMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->updateSeason();
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $res = $this->updateSeason();
        $res->assertStatus(403);
    }

    // delete

    public function testDestroyMethod()
    {
        // admin
        $this->actingAsAdmin();
        $res = $this->deleteSeason();
        $res->assertOk();
        $this->assertDatabaseCount('seasons', 0);

        // super admin
        $this->actingAsSuperAdmin();
        $res = $this->deleteSeason();
        $res->assertOk();
        $this->assertDatabaseCount('seasons', 0);

        // teacher
        $season = $this->createSeasonForTeacher();
        $res = $this->delete(route('admin.seasons.destroy', $season->id));
        $res->assertOk();
        $this->assertDatabaseCount('seasons', 0);
    }

    public function testDestroyMethodError()
    {
        // normal user
        $this->actingAsUser();
        $res = $this->deleteSeason();
        $res->assertStatus(403);
        $this->assertDatabaseCount('seasons', 1);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $res = $this->deleteSeason();
        $res->assertStatus(403);
    }

    // accept

    public function testAcceptedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.accepted', $season->id));
        $res->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.accepted', $season->id));
        $res->assertOk();
    }

    public function testAcceptedMethodError()
    {
        // normal user
        $this->actingAsUser();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.accepted', $season->id));
        $res->assertStatus(403);

        // teacher
        $season = $this->createSeasonForTeacher();
        $res = $this->patch(route('admin.seasons.accepted', $season->id));
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.accepted', $season->id));
        $res->assertStatus(403);
    }

    // reject

    public function testRejectedMethod()
    {
        // admin
        $this->actingAsAdmin();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.rejected', $season->id));
        $res->assertOk();

        // super admin
        $this->actingAsSuperAdmin();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.rejected', $season->id));
        $res->assertOk();
    }

    public function testRejectedMethodError()
    {
        // normal user
        $this->actingAsUser();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.rejected', $season->id));
        $res->assertStatus(403);

        // teacher
        $season = $this->createSeasonForTeacher();
        $res = $this->patch(route('admin.seasons.rejected', $season->id));
        $res->assertStatus(403);

        //teacher of other courses
        $this->actingAsCourseOwnPermission();
        $season = $this->createSeason();
        $res = $this->patch(route('admin.seasons.rejected', $season->id));
        $res->assertStatus(403);
    }
}
