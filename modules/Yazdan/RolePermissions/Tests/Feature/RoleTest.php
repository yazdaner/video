<?php

namespace Yazdan\RolePermissions\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\RolePermissions\Tests\Helper\RoleHelperTest;

class RoleTest extends TestCase
{
    use RefreshDatabase,RoleHelperTest;


    // index

    public function testIndexMethod()
    {
        $this->actingAsAdmin();
        $this->get(route('admin.roles.index'))
        ->assertOk();
    }


    public function testIndexMethodError()
    {
        $this->actingAsUser();
        $this->get(route('admin.roles.index'))
        ->assertStatus(403);

    }

    // store

    public function testStoreMethod()
    {
        $this->actingAsAdmin();
        $data = $this->make();
        $this->post(route('admin.roles.store'),$data)
        ->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseCount('roles',count(RoleRepository::$roles) + 1);
    }

    public function testStoreMethodError()
    {
        $this->actingAsUser();
        $data = $this->make();
        $this->post(route('admin.roles.store'),$data)
        ->assertStatus(403);
        $this->assertDatabaseCount('roles',count(RoleRepository::$roles));
    }

    // edit

    public function testEditMethod()
    {
        $this->actingAsAdmin();
        $data = $this->create();
        $this->get(route('admin.roles.edit',$data->id))
        ->assertOk();
    }

    public function testEditMethodError()
    {
        $this->actingAsUser();
        $data = $this->create();
        $this->get(route('admin.roles.edit',$data->id))
        ->assertStatus(403);
    }

    // update
    public function testUpdateMethod()
    {
        $this->actingAsAdmin();
        $role = $this->create();
        $data = $this->make();
        $this->put(route('admin.roles.update',$role->id),$data)
        ->assertRedirect(route('admin.roles.index'));
        $this->assertEquals($role->fresh()->name,$data['name']);
    }

    public function testUpdateMethodError()
    {
        $this->actingAsUser();
        $role = $this->create();
        $data = $this->make();
        $this->put(route('admin.roles.update',$role->id),$data)
        ->assertStatus(403);
        $this->assertEquals($role->name,$role->fresh()->name);
    }

    // destroy
    public function testDestroyMethod(){
        $this->actingAsAdmin();
        $role = $this->create();
        $this->delete(route('admin.roles.destroy',$role->id))
        ->assertOk();
        $this->assertDatabaseMissing('roles',$role->toArray());
        $this->assertDatabaseMissing('role_has_permissions',$role->toArray());
    }

    public function testDestroyMethodError()
    {
        $this->actingAsUser();
        $role = $this->create();
        $this->delete(route('admin.roles.destroy',$role->id))
        ->assertStatus(403);
        $this->assertDatabaseCount('roles',count(RoleRepository::$roles) + 1);
    }
}
