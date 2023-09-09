<?php

namespace Yazdan\Category\App\Policies;

use Yazdan\User\App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class CategoryPolicy
{
    use HandlesAuthorization;


    public function manage(User $user)
    {
        return $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_CATEGORIES);
    }


}
