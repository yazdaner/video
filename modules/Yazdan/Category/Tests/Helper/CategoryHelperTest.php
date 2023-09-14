<?php

namespace Yazdan\Category\Tests\Helper;


use Yazdan\Category\App\Models\Category;
use Yazdan\RolePermissions\Database\Seeders\RolePermissionsSeeder;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

trait CategoryHelperTest
{

    public function actingAsAdmin()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionsSeeder::class);
        auth()->user()->givePermissionTo(PermissionRepository::PERMISSION_MANAGE_CATEGORIES);

    }

    public function actingAsUser()
    {
        $this->actingAs(User::factory()->unverified()->create());
        $this->seed(RolePermissionsSeeder::class);
    }

    public function create()
    {
        return Category::factory()->create();
    }

    public function make()
    {
        return Category::factory()->make()->toArray();
    }
}
