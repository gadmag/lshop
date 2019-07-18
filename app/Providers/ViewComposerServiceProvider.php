<?php

namespace App\Providers;

use App\Http\ViewComposers\BlocksComposer;
use App\Http\ViewComposers\ChartsComposer;
use App\Order;
use App\User;
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

    public function composeBlocks()
    {
        view()->composer(['block.footer', 'block.footer_bottom', 'block.top_head'], BlocksComposer::class);

    }

    public function composeAdminBlocks()
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
}
