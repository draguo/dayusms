<?php

namespace Draguo\Dayusms;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Draguo\Dayusms\Sms as Sms;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/config/dayusms.php' => config_path('dayusms.php'),
        ]);
        $this->app->singleton('sms', function(){
            return new Sms();
        });
    }

    public function provides()
    {
        return ['sms'];
    }
}
