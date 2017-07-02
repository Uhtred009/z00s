<?php

namespace Olymbytes\Z00s;

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
            __DIR__.'/../config/olymbytes-z00s.php' => config_path('olymbytes-z00s.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/olymbytes-z00s.php', 'olymbytes-z00s');

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
