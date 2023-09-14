<?php

namespace Yazdan\Payment\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\Payment\App\Models\Payment;
use Yazdan\Payment\App\Policies\PaymentPolicy;
use Yazdan\Payment\Gateways\Gateway;
use Yazdan\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class PaymentServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/payment_routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');

        Gate::policy(Payment::class, PaymentPolicy::class);

        $this->loadViewsFrom(__DIR__ . '/../../Resources/views', 'Payment');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../Resources/lang/');
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();
        });


        config()->set('sidebar.items.payments', [
            'icon' => 'i-transactions',
            'url' => route('admin.payments.index'),
            'title' => 'تراکنش ها',
            'permission' => PermissionRepository::PERMISSION_MANAGE_PAYMENTS,
        ]);
    }
}
