<?php
namespace Yazdan\Discount\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\Discount\App\Models\Discount;
use Yazdan\Discount\App\Policies\DiscountPolicy;
use Yazdan\Discount\App\Providers\EventServiceProvider;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class DiscountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/discount_routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views', 'Discount');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../Resources/Lang');
        Gate::policy(Discount::class, DiscountPolicy::class);
    }

    public function boot()
    {

        config()->set('sidebar.items.discount', [
            'icon' => 'i-discounts',
            'url' => route('admin.discounts.index'),
            'title' => 'تخفیف',
            'permission' => PermissionRepository::PERMISSION_MANAGE_DISCOUNT,
        ]);

    }
}
