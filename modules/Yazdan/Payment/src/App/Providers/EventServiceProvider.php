<?php

namespace Yazdan\Payment\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yazdan\Course\App\Listeners\RegisterUserInTheCourse;
use Yazdan\Payment\App\Events\PaymentWasSuccessful;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        PaymentWasSuccessful::class => [
            RegisterUserInTheCourse::class,
        ]
    ];

    public function boot()
    {
        //
    }
}
