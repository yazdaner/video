<?php

namespace Yazdan\RolePermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\RolePermissions\Repositories\RoleRepository;

class RolePermissionsSeeder extends Seeder
{

    public function run()
    {
        foreach(PermissionRepository::$permissions as $permission){
            Permission::findOrCreate($permission);
        }

        foreach(RoleRepository::$roles as $role => $permissions){
            Role::findOrCreate($role)->syncPermissions($permissions);
        }

    }
}
