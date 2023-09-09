<?php

namespace Yazdan\Payment\App\Policies;

use Yazdan\User\App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        if($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_PAYMENTS)) return true;
    }


}
