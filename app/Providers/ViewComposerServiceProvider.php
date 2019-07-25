<?php

namespace App\Providers;

use App\Http\ViewComposers\BlocksComposer;
use App\Http\ViewComposers\ChartsComposer;
use App\Order;
use App\User;
use App\Menu;
use Illuminate\Support\ServiceProvider;

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
        view()->composer(['AdminLTE.partials.small_box'], function($view){
            $view->with([
                'countUser' => User::count(),
                'countOrder' => Order::count(),
                'countStatus' => Order::where('order_status_id',5)->count()
            ]);
        });

        view()->composer(['AdminLTE.partials.order_box'], function ($view){
            $view->with([
                'orders' => Order::with('status')->latest('created_at')->take(6)->get()
            ]);
        });

        view()->composer(['AdminLTE.partials.chart_box'], ChartsComposer::class);
    }

    protected function composeMenu()
    {
        view()->composer(['menu.nav'], function($view){
            $view->with('mainMenu', Menu::getMenuItem('main_menu'));
//            $view->with('secondMenu', Menu::ofType('second_menu')->orderBy('order')->get());
        });
    }
}
