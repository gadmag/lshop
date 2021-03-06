<?php

namespace App\Providers;

use App\Catalog;
use App\Page;
use Facades\App\Services\Product\ProductQueries;
use Illuminate\Support\Facades\Route;
use App\Article;
use App\Product;
use Facades\App\Services\Product\CacheProductQueries;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();


        Route::bind('alias', function ($id) {

            if (is_numeric($id)) {
                $article = Article::published()->ofType('news')->findOrFail(intval($id));
            } else {
                preg_match('|(.*)-|', $id, $m);
                $article = Article::published()->ofType('news')->findOrFail($m[1]);
            }
            return $article;
        });

        Route::bind('photo', function ($id) {

            if (is_numeric($id)) {
                $photo = Article::published()->findOrFail(intval($id));
            } else {
                $photo = Article::where('alias', $id)->ofType('photo')->published()->firstOrFail();
            }
            return $photo;
        });

        Route::bind('design_alias', function ($id) {

            if (is_numeric($id)) {
                $design = Article::published()->findOrFail(intval($id));
            } else {
                $design = Article::where('alias', $id)->ofType('design')->published()->firstOrFail();
            }
            return $design;
        });

        Route::bind('page_alias', function ($id) {
            if (is_numeric($id)) {
                $page = Page::active()->findOrFail(intval($id));
            } else {
                $page = Page::whereAlias($id)->active()->firstOrFail();
            }
            return $page;
        });

        Route::bind('catalog_alias',function ($id){
            if (is_numeric($id))
            {
                $catalog = Catalog::published()->findOrFail(intval($id));
            }else{
                $catalog = Catalog::whereAlias($id)->published()->firstOrFail();
            }
            return $catalog;
        });
        Route::bind('product_alias', function ($id) {
            if (is_numeric($id)) {
                $product = CacheProductQueries::getById($id);
            } else {
                $product = CacheProductQueries::getByAlias($id);
            }
            return $product;
        });

        Route::bind('tags', function ($name) {
            return \App\Tag::where('name', $name)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
