<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Category;
use App\Observers\CategoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\Contracts\CartServiceContract',
            'App\Services\CartService'
        );

        $this->app->bind(
            'App\Services\Contracts\ProductServiceContract',
            'App\Services\ProductService'
        );

        $this->app->bind(
            'App\Services\Contracts\CategoryServiceContract',
            'App\Services\CategoryService'
        );

        $this->app->bind(
            'App\Services\Contracts\TranslateServiceContract',
            'App\Services\TranslateService'
        );
    }
}
