<?php

namespace Yazdan\Payment\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        if($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_PAYMENTS)) return true;
    }


}
