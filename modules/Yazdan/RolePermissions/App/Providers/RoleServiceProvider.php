<?php

namespace Yazdan\RolePermissions\App\Providers;

use Database\Seeders\DatabaseSeeder;
use Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Yazdan\RolePermissions\App\Policies\RolePermissionPolicy;
use Yazdan\RolePermissions\Database\Seeders\RolePermissionsSeeder;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class RoleServiceProvider extends ServiceProvider
{

    public function register()
    {
        Route::middleware('web')
                ->group(__DIR__ . '/../../Routes/role_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/', 'RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../Resources/Lang/');

        DatabaseSeeder::$seeders[] = RolePermissionsSeeder::class;

        Gate::policy(Role::class,RolePermissionPolicy::class);
        Gate::before(function($user){
            return $user->hasPermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN) ? true : null;
        });
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.role-permissions', [
                'icon' => 'i-role-permissions',
                'url' => route('admin.roles.index'),
                'title' => 'نقشهای کاربری',
                'permission' => PermissionRepository::PERMISSION_MANAGE_ROLE_PERMISSIONS,
            ]);
        });
    }

}
