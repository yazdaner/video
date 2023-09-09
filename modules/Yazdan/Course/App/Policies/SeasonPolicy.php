<?php

namespace Yazdan\Course\App\Policies;

use Yazdan\User\App\Models\User;
use Yazdan\Course\App\Models\Season;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class SeasonPolicy
{
    use HandlesAuthorization;


    public function edit(User $user,Season $season)
    {
        if( $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES) )
            return true;

        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) &&
                $season->course->teacher_id == $user->id ;
    }

    public function delete(User $user,Season $season)
    {
        if( $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES) )
            return true;

        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) &&
                $season->course->teacher_id == $user->id ;
    }

    public function accepted(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }

    public function rejected(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }


}
