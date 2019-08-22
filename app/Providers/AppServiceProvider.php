<?php

namespace App\Providers;

use App\Services\Product\BaseQueries;
use App\Services\Product\CacheProductQueries;
use App\Services\Product\ProductQueries;
use App\Services\Block\BlockQueries;
use App\Services\Block\CacheBlockQueries;
use App\Services\Block\BlockService;
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
        $this->bindProductService();
        $this->bindBlockService();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function bindProductService(): void
    {
        $this->app->bind(BaseQueries::class, CacheProductQueries::class);

        $this->app->when(CacheProductQueries::class)
            ->needs(BaseQueries::class)
            ->give(ProductQueries::class);
    }

    protected function bindBlockService(): void
    {
        $this->app->bind(BlockService::class, CacheBlockQueries::class);
        $this->app->when(CacheBlockQueries::class)
            ->needs(BlockService::class)
            ->give(BlockQueries::class);
    }
}
