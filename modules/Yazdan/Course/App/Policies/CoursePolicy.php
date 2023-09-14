<?php

namespace Yazdan\Course\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\Course\App\Models\Course;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Models\User;

class CoursePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES);
    }

    public function create(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES);
    }

    public function edit(User $user, Course $course)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        )
            return true;
    }


    public function details(User $user, Course $course)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        )
            return true;
    }

    public function delete(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }

    public function accepted(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }

    public function rejected(User $user)
    {
        return  $user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES);
    }

    public function createSeason(User $user, Course $course)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        )
            return true;
    }

    public function createLesson(User $user, Course $course)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        )
            return true;
    }
}
