<?php

namespace App\Providers;

use App\Services\Product\BaseQueries;
use App\Services\Product\CacheQueries;
use App\Services\Product\ProductQueries;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->bind(BaseQueries::class, ProductQueries::class);
        $this->app->bind(BaseQueries::class, CacheQueries::class);

        $this->app->when(CacheQueries::class)
            ->needs(BaseQueries::class)
            ->give(ProductQueries::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
