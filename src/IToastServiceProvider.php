<?php

namespace IslamAlsayed\Itoast;

use Illuminate\Support\ServiceProvider;

class IToastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'itoast');

        $this->publishes([
            __DIR__ . '/Resources/assets/css' => public_path('vendor/itoast/css'),
            __DIR__ . '/Resources/assets/js' => public_path('vendor/itoast/js'),
            __DIR__ . '/Resources/views' => resource_path('views/vendor/itoast'),
            __DIR__ . '/Config/itoast.php' => config_path('itoast.php'),
            __DIR__ . '/Resources/assets/webfonts' => public_path('vendor/itoast/webfonts'),
        ], 'itoast-all');
    }

    public function register()
    {
        $this->app->singleton('itoast', function () {
            return new IToastManager();
        });

        $this->commands([
            \IslamAlsayed\Itoast\Console\InjectIToastViewCommand::class,
        ]);

        require_once __DIR__ . '/Helpers.php';
    }
}