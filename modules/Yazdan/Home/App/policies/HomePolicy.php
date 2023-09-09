<?php

namespace Yazdan\Dashboard\App\Policies;

use Yazdan\User\App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class HomePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_DASHBOARD);
    }
}

