<?php

namespace Draguo\Dayusms;

use Illuminate\Support\ServiceProvider;

class DayusmsServiceProvider extends ServiceProvider
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
        $this->app->singleton('sms', function(){
            return new Sms();
        });
    }

    public function provides()
    {
        return ['sms'];
    }
}
