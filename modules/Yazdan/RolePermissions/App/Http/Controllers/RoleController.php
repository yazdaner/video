<?php

namespace Yazdan\RolePermissions\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\RolePermissions\App\Http\Requests\RoleRequest;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class RoleController extends Controller
{


    public function index()
    {
        $this->authorize('index',Role::class);
        $roles = RoleRepository::getAllPaginate(10);
        $permissions = PermissionRepository::getAll();
        return view('RolePermissions::index',compact('roles','permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create',Role::class);
        RoleRepository::store($request);
        return redirect()->route('admin.roles.index');
    }

    public function edit($roleId)
    {
        $this->authorize('edit',Role::class);
        $role = RoleRepository::findRoleById($roleId);
        $permissions = PermissionRepository::getAll();
        return view('RolePermissions::edit',compact('role','permissions'));
    }

    public function update(RoleRequest $request,$id)
    {
        $this->authorize('edit',Role::class);
        RoleRepository::update($request,$id);
        return redirect(route('admin.roles.index'));
    }

    public function destroy($roleId)
    {
        $this->authorize('delete',Role::class);
        RoleRepository::delete($roleId);
        return AjaxResponses::SuccessResponses();

    }

}
