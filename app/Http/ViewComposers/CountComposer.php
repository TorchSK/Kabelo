<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ProductServiceContract;

use Cookie;
use Crypt;
use App\User;
use App\Cart;

class CountComposer {

    public function __construct(ProductServiceContract $productService)
    {        
        $this->productService = $productService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $categoryCounts = $this->productService->categoryCounts();

        $view->with('categoryCounts', $categoryCounts);
    }

}