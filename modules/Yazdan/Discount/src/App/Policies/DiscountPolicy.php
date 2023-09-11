<?php

namespace Yazdan\Discount\App\Policies;

use Yazdan\User\App\Models\User;
use Yazdan\Course\App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class DiscountPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        if($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_DISCOUNT)) return true;
    }



}
