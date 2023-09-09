<?php

namespace Yazdan\RolePermissions\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository
{

    const ROLE_TEACHER = 'teacher';
    const ROLE_SUPER_ADMIN = 'super admin';
    static $roles = [
        self::ROLE_TEACHER => [
            PermissionRepository::PERMISSION_TEACH,
            PermissionRepository::PERMISSION_MANAGE_OWN_COURSES
        ],
        self::ROLE_SUPER_ADMIN => [
            PermissionRepository::PERMISSION_SUPER_ADMIN
        ],
    ];

    public static function getAll()
    {
        return Role::all();
    }

    public static function getAllPaginate($value)
    {
        return Role::latest()->paginate($value);
    }

    public static function findRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public static function getAllExceptById($id)
    {
        return self::getAll()->filter(function($item) use ($id){
            return $item->id != $id;
        });
    }

    public static function store($value)
    {
        $role = Role::create([
            'name' => $value->name,
        ]);

        $role->syncPermissions($value->permissions);
    }

    public static function update($value,$id)
    {
        $role = Role::findById($id);

        $role->update([
            'name' => $value->name,
        ]);

        $role->syncPermissions($value->permissions);
    }

    public static function delete($roleId)
    {
        return Role::whereId($roleId)->delete();
    }
}
