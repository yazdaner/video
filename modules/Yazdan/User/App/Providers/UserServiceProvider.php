<?php

namespace Yazdan\User\App\Providers;

use Yazdan\User\App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\User\App\Policies\UserPolicy;
use Yazdan\User\Database\Seeders\UsersSeeder;
use Yazdan\User\App\Http\Middleware\StoreUserIp;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('auth.providers.users.model', User::class);

        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/user_routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../Resources/Lang');
        DatabaseSeeder::$seeders[] = UsersSeeder::class;
        Gate::policy(User::class, UserPolicy::class);
    }

    public function boot()
    {
        $this->app->router->pushMiddlewareToGroup('web', StoreUserIp::class);

        config()->set('sidebar.items.users', [
            'icon' => 'i-users',
            'url' => route('admin.users.index'),
            'title' => 'کاربران',
            'permission' => PermissionRepository::PERMISSION_MANAGE_USERS,
        ]);

        config()->set('sidebarHome.items.profile', [
            'icon' => 'i-users',
            'url' => route('users.profile'),
            'title' => 'پروفایل'
        ]);
    }
}
