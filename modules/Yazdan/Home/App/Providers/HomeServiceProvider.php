<?php
namespace Yazdan\Home\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Yazdan\Dashboard\App\Models\Home;
use Illuminate\Support\ServiceProvider;
use Yazdan\Dashboard\App\Policies\HomePolicy;

class HomeServiceProvider extends ServiceProvider
{

    public function register()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/home_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/','Home');
        $this->mergeConfigFrom(__DIR__ . '/../../Config/sidebar.php','sidebarHome');

        Gate::policy(Home::class,HomePolicy::class);
    }

    public function boot()
    {
        //
    }

}
