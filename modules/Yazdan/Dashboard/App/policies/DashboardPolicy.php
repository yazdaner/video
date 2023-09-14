<?php

namespace Yazdan\Dashboard\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

class DashboardPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_DASHBOARD);
    }
}

