<?php

namespace Olymbytes\Z00s;

use Olymbytes\Z00s\Auth\LoginProxy;
use Illuminate\Support\ServiceProvider;

class Z00sServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/z00s.php' => config_path('z00s.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/z00s.php', 'z00s');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LoginProxy', function ($app) {
            return new LoginProxy;
        });
    }
}
