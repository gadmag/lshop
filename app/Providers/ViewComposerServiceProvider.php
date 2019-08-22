<?php

namespace App\Providers;

use App\Http\ViewComposers\BlocksComposer;
use App\Http\ViewComposers\ChartsComposer;
use App\Http\ViewComposers\NewProductComposer;
use App\Http\ViewComposers\SpecialComposer;
use App\Order;
use App\Services\Product\ProductQueries;
use App\User;
use App\Menu;
use Illuminate\Support\ServiceProvider;
use function foo\func;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeMenu();
        $this->composeBlocks();
        $this->composeNewProductBlock();
        $this->composeSpecialProduct();
        $this->composeAdminBlocks();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function composeBlocks()
    {
        view()->composer(['block.footer', 'block.footer_bottom', 'block.top_head'], BlocksComposer::class);

    }

    protected function composeAdminBlocks()
    {
        view()->composer(['AdminLTE.partials.small_box'], function ($view) {
            $view->with([
                'countUser' => User::count(),
                'countOrder' => Order::count(),
                'countStatus' => Order::where('order_status_id', 5)->count()
            ]);
        });

        view()->composer(['AdminLTE.partials.order_box'], function ($view) {
            $view->with([
                'orders' => Order::with('status')->latest('created_at')->take(6)->get()
            ]);
        });

        view()->composer(['AdminLTE.partials.chart_box'], ChartsComposer::class);
    }

    protected function composeMenu()
    {
        view()->composer(['menu.nav'], function ($view) {
            $view->with('mainMenu', Menu::getMenuItem('main_menu'));
        });
    }

    protected function composeNewProductBlock()
    {
        view()->composer('block.new_product', NewProductComposer::class);
    }

    protected function composeSpecialProduct()
    {
        view()->composer('block.special_product', SpecialComposer::class);
    }
}
