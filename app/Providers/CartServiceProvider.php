<?php

namespace App\Providers;

use App\ShoppingCart\Cart;
use App\ShoppingCart\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart', function ($app){
            return new Cart($app->make(RepositoryInterface::class));
        });
    }
}
