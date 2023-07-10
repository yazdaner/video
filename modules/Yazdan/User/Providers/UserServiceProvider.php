<?php

namespace Yazdan\User\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Yazdan\User\Models\User;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('auth.providers.users.model',User::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations/');
        $this->loadViewsFrom(__DIR__.'/../Resources/views','User');

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Yazdan\User\Database\Factories\\' . class_basename($modelName) .'Factory' ;
        });

    }
}
