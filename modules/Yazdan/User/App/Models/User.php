<?php

namespace Yazdan\User\App\Models;

use Laravel\Sanctum\HasApiTokens;
use Yazdan\Media\App\Models\Media;
use Yazdan\Course\App\Models\Course;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yazdan\User\App\Notifications\VerifyMailNotification;
use Yazdan\RolePermissions\Repositories\PermissionRepository;
use Yazdan\User\App\Notifications\ResetPasswordEmailCodeNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_id');
    }


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }

    public function sendResetPasswordEmailCodeNotification()
    {
        $this->notify(new ResetPasswordEmailCodeNotification());
    }

    public function getVerifyAttribute()
    {
        return $this->hasVerifiedEmail() ? 'تایید شده' : 'تایید نشده';
    }

    public function getVerifyStyleAttribute()
    {
        return $this->hasVerifiedEmail() ? 'text-success' : 'text-error';
    }


    public function profilePath()
    {
        return $this->username ? route('users.showProfile', $this->username) : route('users.showProfile', 'username');
    }

    public function getAvatar($size = 'original')
    {
        if (isset($this->avatar_id)) {
            return $this->avatar->thumb($size);
        } else {
            return asset('img/profile.jpg');
        }
    }

    public function hasAccessToCourse(Course $course)
    {
        if (
            $this->can('manage', Course::class) ||
            $this->id == $course->teacher_id ||
            $course->students->contains($this->id)
        ) {
            return true;
        }
        return false;
    }

    public function purchases()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function studentsCount()
    {
        //todo
        return 0;
    }
}
