<?php

namespace Islam\Itoast;

use Illuminate\Support\ServiceProvider;

class IToastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'itoast');

        $this->publishes([
            __DIR__ . '/../Resources/css' => public_path('vendor/itoast/css'),
            __DIR__ . '/../Resources/js' => public_path('vendor/itoast/js'),
            __DIR__ . '/../Resources/views' => resource_path('views/vendor/itoast'),
            __DIR__ . '/../Config/itoast.php' => config_path('itoast.php'),
        ], 'itoast-all');
    }

    public function register()
    {
        $this->app->singleton('itoast', function () {
            return new IToastManager();
        });

        require_once __DIR__ . '/Helpers.php';
    }
}