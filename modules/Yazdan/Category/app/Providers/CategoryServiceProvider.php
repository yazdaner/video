<?php

namespace Yazdan\Category\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\Category\App\Models\Category;
use Yazdan\Category\App\Policies\CategoryPolicy;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class CategoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/category_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/', 'Category');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');

        Gate::policy(Category::class, CategoryPolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.categories', [
                'icon' => 'i-categories',
                'url' => route('admin.categories.index'),
                'title' => 'دسته بندی',
                'permission' => PermissionRepository::PERMISSION_MANAGE_CATEGORIES,
            ]);
        });
    }
}
