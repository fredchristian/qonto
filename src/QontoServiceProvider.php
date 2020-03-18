<?php

namespace Brocorp\Qonto;

use Brocorp\Qonto\QontoApi;
use Brocorp\Qonto\Console\QontoInit;
use Brocorp\Qonto\Console\QontoSync;
use Brocorp\Qonto\Console\QontoInstall;
use Illuminate\Support\ServiceProvider;

class QontoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/qonto.php', 'qonto');
        
        $this->app->singleton('qonto_api', function($app) {
            return new QontoApi();
        });
    }


    public function boot()
    {
        // loading migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // publishing config
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/qonto.php' => config_path('qonto.php')], 'config');
        }
        
        // register commands
        $this->commands([
            QontoInstall::class,
            QontoInit::class,
            QontoSync::class,
        ]);
    }
}
