<?php

namespace App\Providers;

use App\Observers\OptionObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Option;
use App\Order;
use App\Product;
use App\ShoppingCart\Repositories\Contracts\RepositoryInterface;
use App\ShoppingCart\Repositories\SessionRepository;
use App\Services\Product\BaseQueries;
use App\Services\Product\CacheProductQueries;
use App\Services\Product\ProductQueries;
use App\Services\Block\BlockQueries;
use App\Services\Block\CacheBlockQueries;
use App\Services\Block\BlockService;
use Illuminate\Support\ServiceProvider;
use function foo\func;


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
        $this->bindShoppingRepository();
        Product::observe(ProductObserver::class);
        Option::observe(OptionObserver::class);
        Order::observe(OrderObserver::class);
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

    protected function bindShoppingRepository()
    {

        $this->app->bind(RepositoryInterface::class, function ($app){
            return new SessionRepository();
        });
    }
}
