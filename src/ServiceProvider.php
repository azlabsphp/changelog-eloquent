<?php

namespace Drewlabs\Changelog\Eloquent;

use Drewlabs\Changelog\Logger;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Boots application services
     * 
     * @return void 
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => $this->app->basePath('database/migrations'),
        ], 'changelogs-migrations');

        // Register library commands
        $this->commands([
            \Drewlabs\Changelog\Eloquent\Commands\Migrate::class
        ]);

        // Register eloquent log driver
        Logger::getInstance()->registerDriver(new LogDriver, 'eloquent');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}