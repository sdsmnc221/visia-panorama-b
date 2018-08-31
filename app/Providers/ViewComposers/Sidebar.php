<?php

namespace App\Providers\ViewComposers;

use Illuminate\Contracts\View\View;
 
class Sidebar{

    protected $current_route;
    protected $sidebar = [
        'dashboard' => false,
        'authors/all' => false,
        'datasets/all' => false,
        'datasets/create_update' => false,
        'categories/all' => false,
        'categories/cu' => false
    ];
    protected $alias = [
        'dashboard' => '/dashboard/',
        'authors/all' => '/authors\/all/',
        'datasets/all' => '/datasets\/([0-9]|all)/',
        'datasets/create_update' => '/datasets\/create_update/',
        'categories/all' => '/categories\/([0-9]|all)/',
        'categories/cu' => '/categories\/cu\/create|update/'
    ];
 
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct() {
        $this->current_route = request()->path();
    }
 
    /**
     * @param \Illuminate\Contracts\View\View $view
     */
    public function compose(View $view)
    {   
        foreach (array_keys($this->sidebar) as $section) {
            $this->sidebar[$section] = preg_match($this->alias[$section], $this->current_route) !== 0 ? true : false;
        }
        $view->with('is_active', $this->sidebar);
    }
}

?>