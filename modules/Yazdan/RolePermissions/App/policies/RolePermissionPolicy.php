<?php

namespace Yazdan\RolePermissions\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function create(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function edit(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function delete(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

}

