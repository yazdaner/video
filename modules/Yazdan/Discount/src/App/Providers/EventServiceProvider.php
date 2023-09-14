<?php

namespace Yazdan\Discount\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yazdan\Discount\App\Listeners\UpdateUsedDiscountsForPayment;
use Yazdan\Payment\App\Events\PaymentWasSuccessful;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class
        ]
    ];

    public function boot()
    {
        //
    }
}
