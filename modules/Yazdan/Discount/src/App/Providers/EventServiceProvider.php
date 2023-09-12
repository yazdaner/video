<?php

namespace Yazdan\Discount\App\Providers;

use Yazdan\Payment\App\Events\PaymentWasSuccessful;
use Yazdan\Discount\App\Listeners\UpdateUsedDiscountsForPayment;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
