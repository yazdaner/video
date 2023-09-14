<?php

namespace Yazdan\User\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_USERS);
    }

    public function edit(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_USERS);
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_USERS);
    }

    public function addRole(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function removeRole(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    public function manualVerify(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_USERS);
    }

    public function updatePhoto(User $user)
    {
        return auth()->check() && $user->id == auth()->id();
    }

    public function profile()
    {
        return auth()->check();
    }
}















