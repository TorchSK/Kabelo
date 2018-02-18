<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        $view->composer('*', 'App\Http\ViewComposers\GlobalComposer');
        $view->composer('includes/filterbar', 'App\Http\ViewComposers\CountComposer');
    }

    public function register()
    {
        //
    }

}