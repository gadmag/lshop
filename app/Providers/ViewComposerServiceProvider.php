<?php

namespace App\Providers;

use App\Block;
use App\Article;
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
        $this->composeNavigation();
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

    public function composeNavigation()
    {
        view()->composer('partials.nav',function ($view){
            $view->with('latest', Article::latest()->first());
        });
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
}
