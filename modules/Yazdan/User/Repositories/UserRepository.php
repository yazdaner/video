<?php
namespace Yazdan\User\Repositories;

use Yazdan\User\App\Models\User;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class UserRepository
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BAN = 'ban';

    static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN,
    ];


    const USER_SUPER_ADMIN = [
        'name' => 'admin',
        'email' => 'a@a.com',
        'password' => '1234',
        'role' => RoleRepository::ROLE_SUPER_ADMIN
    ];

    static $defaultUsers = [
        self::USER_SUPER_ADMIN,
    ];

    public static function getUserByEmail($email)
    {
       return User::whereEmail($email)->first();
    }

    public static function findById($id)
    {
       return User::find($id);
    }

    public static function getTeachers()
    {
       return User::permission('teach')->get();
    }

    public static function paginate($count)
    {
        return User::latest()->paginate($count);
    }


    public static function update($value,$userId)
    {
        $update = [
            'name' => $value->name,
            'email' => $value->email,
            'username' => $value->username,
            'mobile' => $value->mobile,
            'telegram' => $value->telegram,
            'status' => $value->status,
            'bio' => $value->bio,
            'headline' => $value->headline,
            'avatar_id' => $value->avatar_id,
        ];

        if ($value->password) {
            $update['password'] = bcrypt($value->password);
        }

        User::whereId($userId)->update($update);

    }

    public static function upload($request,$userId)
    {
        $user = static::findById($userId);

        if($request->hasFile('avatar')){
            if($user->avatar){
                $user->avatar->delete();
            }
            $images = MediaFileService::publicUpload($request->avatar);
            return $request->request->add(['avatar_id' => $images->id]);
        }else{
            return $request->request->add(['avatar_id' => $user->avatar_id]);
        }
    }

    public static function updateProfile($value)
    {
        auth()->user()->name = $value->name;
        auth()->user()->mobile = $value->mobile;
        auth()->user()->username = $value->username;

        if(auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_TEACH) ||
            auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN))
        {
            auth()->user()->card_number = $value->card_number;
            auth()->user()->shaba = $value->shaba;
            auth()->user()->headline = $value->headline;
            auth()->user()->bio = $value->bio;
        }
        auth()->user()->save();

    }

}
