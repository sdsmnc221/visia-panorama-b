<?php

namespace App\Providers\ComponentProviders;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootComponents();
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

    /**
     * Alias components.
     *
     * @return void
     */
    public function bootComponents() {
        Blade::component('layouts.components.cubtn', 'cubtn');
        Blade::component('layouts.components.cuform', 'cuform');
        Blade::component('layouts.components.cutab', 'cutab');
        Blade::component('layouts.components.modal', 'modal');
        Blade::component('layouts.components.table', 'table');
        Blade::component('layouts.components.toolbar', 'toolbar');
    }
}
