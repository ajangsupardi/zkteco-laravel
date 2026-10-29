<?php

namespace Rynest\Zkteco;

use Illuminate\Support\ServiceProvider;

class ZktecoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/zkteco.php', 'zkteco');
        $this->app->singleton(ZktecoService::class, fn($app) => new ZktecoService($app['config']['zkteco']));
        $this->app->alias(ZktecoService::class, 'zkteco');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/zkteco.php' => config_path('zkteco.php'),
            ], 'zkteco-config');
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
}
