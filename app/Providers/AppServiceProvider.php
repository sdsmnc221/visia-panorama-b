<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\Providers\HelpersProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('h', new HelpersProvider());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Providers\HelpersProvider', function ($app) {
            return new HelpersProvider();
        });
    }
}
