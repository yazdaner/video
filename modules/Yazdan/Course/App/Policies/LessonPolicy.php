<?php

namespace Yazdan\Course\App\Policies;

use Yazdan\User\App\Models\User;
use Yazdan\Course\App\Models\Lesson;
use Illuminate\Auth\Access\HandlesAuthorization;
use Yazdan\Course\App\Models\Course;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class LessonPolicy
{
    use HandlesAuthorization;


    public function create(User $user,Course $course)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        )
            return true;
    }


    public function edit(User $user, Lesson $lesson)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $lesson->course->teacher_id == $user->id)
        )
            return true;
    }


    public function destroy(User $user, Lesson $lesson)
    {
        if (($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES)) ||
            ($user->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_OWN_COURSES) && $lesson->course->teacher_id == $user->id)
        )
            return true;
    }
}
