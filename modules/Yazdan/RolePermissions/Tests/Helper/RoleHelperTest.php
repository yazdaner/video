<?php

namespace Yazdan\RolePermissions\Tests\Helper;

use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Yazdan\RolePermissions\Database\Seeders\RolePermissionsSeeder;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

trait RoleHelperTest
{
    use WithFaker;

    public function createUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionsSeeder::class);
    }

    public function actingAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function actingAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN);
    }

    public function actingAsUser()
    {
        $this->createUser();
    }

    public function make(){
        return [
            'name' => $this->faker->name,
            'permissions' => collect(PermissionRepository::$permissions)->random(2)->toArray(),
        ];
    }

    public function create()
    {
        return Role::create(['name' => $this->faker->name])
        ->syncPermissions($this->faker->randomElements(PermissionRepository::$permissions, 2));
    }
}
