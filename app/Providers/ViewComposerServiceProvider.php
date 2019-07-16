<?php

namespace App\Providers;

use App\Block;
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
        view()->composer(['block.footer'], function($view){
            $view->with('blocks', Block::published()->weight()->whereRegion('footer')->get());
        });
        view()->composer(['block.footer_bottom'], function($view){
            $view->with('blocks', Block::published()->weight()->whereRegion('footer_bottom')->get());
        });
        view()->composer(['block.top_head'], function($view){
            $view->with('blocks', Block::published()->weight()->whereRegion('top_head')->get());
        });
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
    }
}
