<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('env', function() {
    dd(env('APP_ENV'));
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'namespace' => 'Admin', 'roles' => ['Admin', 'Moderator']], function () {
    Route::get('/', function () {
        return view('AdminLTE.admin');
    });
    Route::get('articles/{type}/all', 'ArticleController@index');
    Route::post('articles/{type}/all', ['as' => 'store', 'uses' => 'ArticleController@store']);
    Route::get('articles/{type}/create', ['as' => 'create', 'uses' => 'ArticleController@create']);
    Route::resources([
        'articles' => 'ArticleController',
        'pages' => 'PageController',
        'products' => 'ProductController',
        'catalogs' => 'CatalogController',
        'menus' => 'MenuController',
        'users' => 'UserController',
        'blocks' => 'BlockController',
        'coupons' => 'CouponController'
    ],
        [
            'except' => ['show']
        ]);
    //orders
    Route::get('orders', ['as' => 'order.index', 'uses' => 'OrderController@index']);
    Route::get('orders/{id}', ['as' => 'order.show', 'uses' => 'OrderController@show']);
    //relates
    Route::get('option/{id}', 'ProductController@deleteOption');
    //upload
    Route::get('upload/{id}', 'UploadController@deleteFile');
    Route::get('uploadFile', 'UploadController@uploadFile');
    Route::post('menu/updatesort/', ['as' => 'uploadsort', 'uses' => 'MenuController@updateMenuSort']);

    /**
     * filemanager
     */
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('designs/{design_alias}', ['as' => 'design.show', 'uses' => 'ArticleController@showDesign']);
    Route::get('designs', ['as' => 'design.index', 'uses' => 'ArticleController@indexDesign']);

    /*page*/
    Route::get('pages/{page_alias}', ['as' => 'page.show', 'uses' => 'PageController@show']);
    /*product*/
    Route::get('products/{product_alias}', ['as' => 'product.show', 'uses' => 'ProductController@show']);
    Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('api/products', ['as' => 'product.api', 'uses' => 'ProductController@getJsonProducts']);
    Route::get('add-to-cart/{id}', ['as' => 'product.addToCart', 'uses' => 'ProductController@addToCart']);
    Route::get('reduce/{id}', ['as' => 'product.reduceByOne', 'uses' => 'ProductController@getReduceByOne']);
    Route::get('remove/{id}', ['as' => 'product.removeItem', 'uses' => 'ProductController@getRemoveItem']);
    Route::get('add-to-wishlist/{id}', ['as' => 'product.addToWishList', 'uses' => 'ProductController@addToWishList']);
    Route::get('remove-to-wishlist/{id}', ['as' => 'product.removeToWishList', 'uses' => 'ProductController@removeToWishList']);
    Route::get('wishlist', ['as' => 'product.WishList', 'uses' => 'ProductController@getWishList']);
    Route::get('wishlist-json', ['as' => 'product.WishListJson', 'uses' => 'ProductController@getWishListJson']);
    Route::get('shopping-cart', ['as' => 'product.shoppingCart', 'uses' => 'ProductController@getCart']);
    Route::get('shopping-cart-detail', ['as' => 'product.shoppingCartDerail', 'uses' => 'ProductController@getCartDetail']);
    /*checkout*/
    Route::get('checkout', ['as' => 'checkout', 'uses' => 'CheckoutController@getCheckout', 'middleware' => 'auth']);
    Route::post('checkout', ['as' => 'checkoutPost', 'uses' => 'CheckoutController@postCheckout', 'middleware' => 'auth']);
    /*catalog*/
    Route::get('catalogs/{catalog}', ['as' => 'catalog.show', 'uses' => 'CatalogController@show']);
    Route::get('catalogs', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);


    Route::get('search', ['as' => 'product.search', 'uses' => 'ProductController@search']);

    Route::get('rss.xml', ['as' => 'feed', 'uses' => 'ArticleController@feed']);


    //Route::get('tags/{tags}', 'TagsController@show');
    Route::get('/', ['as' => 'front', 'uses' => 'FrontController@index']);
});


Route::group(['prefix' => 'user', 'middleware' => 'web'], function () {


    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', ['as' => 'user.profile', 'uses' => 'Auth\ProfileController@getProfile']);
        Route::get('logout', ['as' => 'user.logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']); //Just added to fix issue

    });
});

Route::get('/home', 'HomeController@index');


