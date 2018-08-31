<?php

namespace App\Providers\ViewComposers;

use Illuminate\Support\ServiceProvider;

class ComposersServiceProvider extends ServiceProvider
{
    protected $sidebar;

    public function __construct() {
        // $this->sidebar = new SidebarComposer();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.sidebar', 'App\Providers\ViewComposers\Sidebar');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
