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
        $view->composer(['includes/header', 'cart.*','includes/footer','home.*','categories.products','search.all'], 'App\Http\ViewComposers\GlobalComposer');
        $view->composer(['includes/*', 'cart.*','products.*','categories.products','home.cover','pages.contact','search.all','admin.eshop.category','admin.tabs'], 'App\Http\ViewComposers\AppnameComposer');
        $view->composer(['includes/filterbar','includes/catbar'], 'App\Http\ViewComposers\CountComposer');
    }

    public function register()
    {
        //
    }

}