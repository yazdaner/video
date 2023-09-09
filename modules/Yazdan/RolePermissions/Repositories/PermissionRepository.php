<?php

namespace Yazdan\RolePermissions\Repositories;

use Spatie\Permission\Models\Permission;


class PermissionRepository
{

    const PERMISSION_MANAGE_CATEGORIES = 'manage categories';
    const PERMISSION_MANAGE_USERS = 'manage users';
    const PERMISSION_MANAGE_COURSES = 'manage courses';
    const PERMISSION_MANAGE_OWN_COURSES = 'manage own courses';
    const PERMISSION_MANAGE_ROLE_PERMISSIONS = 'manage role permissions';
    const PERMISSION_MANAGE_PAYMENTS = 'manage payments';
    const PERMISSION_MANAGE_SETTLEMENTS = 'manage settlements';
    const PERMISSION_MANAGE_DISCOUNT = 'manage discounts';
    const PERMISSION_MANAGE_TICKETS = "manage tickets";
    const PERMISSION_MANAGE_COMMENTS = "manage comments";
    const PERMISSION_MANAGE_DASHBOARD = "manage dashboard";
    const PERMISSION_TEACH = 'teach';
    const PERMISSION_MANAGE_SLIDES = "manage slides";
    static $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_TEACH,
        self::PERMISSION_MANAGE_CATEGORIES,
        self::PERMISSION_MANAGE_ROLE_PERMISSIONS,
        self::PERMISSION_MANAGE_COURSES,
        self::PERMISSION_MANAGE_OWN_COURSES,
        self::PERMISSION_MANAGE_USERS,
        self::PERMISSION_MANAGE_PAYMENTS,
        self::PERMISSION_MANAGE_SETTLEMENTS,
        self::PERMISSION_MANAGE_DISCOUNT,
        self::PERMISSION_MANAGE_TICKETS,
        self::PERMISSION_MANAGE_COMMENTS,
        self::PERMISSION_MANAGE_SLIDES,
        self::PERMISSION_MANAGE_DASHBOARD
    ];

    const PERMISSION_SUPER_ADMIN = 'super admin';


    public static function getAll()
    {
        return Permission::all();
    }
}
