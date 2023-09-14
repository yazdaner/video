<?php

namespace Yazdan\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\User\App\Http\Requests\AddRoleRequest;
use Yazdan\User\App\Http\Requests\UpdateProfileRequest;
use Yazdan\User\App\Http\Requests\UpdateUserPhotoRequest;
use Yazdan\User\App\Http\Requests\UpdateUserRequest;
use Yazdan\User\App\Models\User;
use Yazdan\User\Repositories\UserRepository;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('index',User::class);
        $roles = RoleRepository::getAll();
        $users = UserRepository::paginate(10);
        return view('User::admin.index',compact('users','roles'));
    }

    public function edit(User $user)
    {
        $statuses = UserRepository::$statuses;
        return view('User::admin.edit',compact('user','statuses'));
    }

    public function update(UpdateUserRequest $request,$userId)
    {
        $this->authorize('edit',User::class);

        UserRepository::upload($request,$userId);
        UserRepository::update($request,$userId);

        newFeedbacks();
        return redirect()->route('admin.users.index');
    }

    public function destroy($userId)
    {
        $this->authorize('delete',User::class);
        $user = UserRepository::findById($userId);

        if($user->avatar){
            $user->avatar->delete();
        }
        $user->delete();

        return AjaxResponses::SuccessResponses();
    }

    public function addRole(AddRoleRequest $request,User $user)
    {
        $this->authorize('addRole',User::class);
        $user->assignRole($request->role);
        newFeedbacks('با موفقیت',"نقش مورد نظر به کاربر {$user->name} داده شد",'success');
        return redirect()->route('admin.users.index');
    }

    public function removeRole(User $user,Role $role)
    {
        $this->authorize('removeRole',User::class);
        $user->removeRole($role->id);
        return AjaxResponses::SuccessResponses();
    }

    public function manualVerify(User $user)
    {
        $this->authorize('manualVerify',User::class);
        $user->markEmailAsVerified();
        return AjaxResponses::SuccessResponses();

    }

    public function updatePhoto(UpdateUserPhotoRequest $request)
    {
        $this->authorize('updatePhoto',User::class);

        $image = MediaFileService::publicUpload($request->image);
        if(auth()->user()->avatar) auth()->user()->avatar->delete();
        auth()->user()->avatar_id = $image->id;
        auth()->user()->save();
        newFeedbacks();
        return back();
    }

    public function profile()
    {
        $this->authorize('profile',User::class);
        return view('User::profile.index');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->authorize('profile',User::class);
        UserRepository::updateProfile($request);
        newFeedbacks();
        return back();
    }

    // public function showProfile(User $user)
    // {
    //     dd($user->username);
    // }
}

