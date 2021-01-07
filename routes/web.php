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
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'namespace' => 'Admin', 'roles' => ['admin', 'moderator']], function () {
    Route::get('/', function () {
        return view('AdminLTE.admin-front');
    });
    Route::get('articles/{type}/all', 'ArticleController@index');
    Route::post('articles/{type}/all', ['as' => 'store', 'uses' => 'ArticleController@store']);
    Route::get('articles/{type}/create', ['as' => 'create', 'uses' => 'ArticleController@create']);
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
    Route::resources([
        'articles' => 'ArticleController',
        'pages' => 'PageController',
        'products' => 'ProductController',
        'services' => 'ServiceController',
        'fonts' => 'FontController',
        'catalogs' => 'CatalogController',
        'menus' => 'MenuController',
        'users' => 'UserController',
        'blocks' => 'BlockController',
        'fieldOptions' => 'FieldOptionController',
        'service' => 'ServiceController',
        'orderStatus' => 'OrderStatusController',
        'coupons' => 'CouponController',
        'shipments' => 'ShipmentController',
        'payments' => 'PaymentController'
    ],
        [
            'except' => ['show']
        ]);
    //orders
    Route::resources(['orders' => 'OrderController']);
    Route::get('api/orders', ['as' => 'order.api', 'uses' => 'OrderController@search']);
    Route::post('api/orders/add-to-cart/{id}', ['as' => 'order.addToCart', 'uses' => 'OrderController@addToCart']);
    Route::get('api/orders/remove-to-cart/{id}', ['as' => 'order.removeToCart', 'uses' => 'OrderController@removeItem']);
    Route::post('api/orders/update-cart/{id}', ['as' => 'order.updateCart', 'uses' => 'OrderController@updateCart']);
    //relates
    Route::get('option/{id}', 'ProductController@deleteOption');

    //upload
    Route::post('menus/updateTree', ['as' => 'menus.updateTree', 'uses' => 'MenuController@updateTree']);
//    Route::post('uploadFiles',['as' => 'upload.files','uses' => 'ProductController@uploadFiles']);

    /**
     * filemanager
     */
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});

Route::group(['middleware' => 'web'], function () {

    Route::get('designs/{design_alias}', ['as' => 'design.show', 'uses' => 'ArticleController@showDesign']);
    Route::get('designs', ['as' => 'design.index', 'uses' => 'ArticleController@indexDesign']);

    //uploads
    Route::get('upload/{id}', 'UploadController@deleteFile');
    Route::post('uploadFiles',['as' => 'upload.files', 'uses' => 'UploadController@uploadFiles']);
    /*page*/
    Route::get('pages/{page_alias}', ['as' => 'page.show', 'uses' => 'PageController@show']);

    /*product*/
    Route::get('products/{product_alias}', ['as' => 'product.show', 'uses' => 'ProductController@show']);
    Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('api/products', ['as' => 'product.api', 'uses' => 'ProductController@getJsonProducts']);
    Route::get('api/products/search', ['as' => 'product.searchJson', 'uses' => 'ProductController@searchJson']);

    /*cart*/
    Route::get('api/add-to-cart/{id}', ['as' => 'product.addToCart', 'uses' => 'ProductController@addToCart']);
    Route::get('api/reduce/{id}', ['as' => 'product.reduceByOne', 'uses' => 'ProductController@reduceByOne']);
    Route::get('api/remove/{id}', ['as' => 'product.removeItem', 'uses' => 'ProductController@removeItem']);
    Route::get('api/update-cart/{id}', ['as' => 'product.updateCart', 'uses' => 'ProductController@updateCart']);
    Route::get('api/add-coupon/{code}', ['as' => 'product.addCoupon', 'uses' => 'ProductController@addCoupon']);
    Route::get('api/add-shipment/{id}', ['as' => 'addShipment', 'uses' => 'ProductController@addShipment']);
    Route::get('api/add-engraving/{id}', ['as' => 'addEngraving', 'uses' => 'ProductController@addEngraving']);
    Route::get('api/remove-engraving', ['as' => 'removeEngraving', 'uses' => 'ProductController@removeEngravingItem']);


    /* WishList */
    Route::get('add-to-wishlist/{id}', ['as' => 'product.addToWishList', 'uses' => 'ProductController@addToWishList']);
    Route::get('remove-to-wishlist/{id}', ['as' => 'product.removeToWishList', 'uses' => 'ProductController@removeToWishList']);
    Route::get('wishlist', ['as' => 'product.WishList', 'uses' => 'ProductController@getWishList']);
    Route::get('wishlist-json', ['as' => 'product.WishListJson', 'uses' => 'ProductController@getWishListJson']);

    /*shopping cart*/
    Route::get('shopping-cart', ['as' => 'product.shoppingCart', 'uses' => 'ProductController@getCart']);
    Route::get('shopping-cart-detail', ['as' => 'product.shoppingCartDerail', 'uses' => 'ProductController@getCartDetail']);

    /*checkout*/
    Route::get('checkout', ['as' => 'checkout', 'uses' => 'CheckoutController@getCheckout', 'middleware' => 'auth']);
    Route::post('checkout', ['as' => 'checkoutPost', 'uses' => 'CheckoutController@postCheckout', 'middleware' => 'auth']);
    Route::post('/api/checkout/validStepFirst',['as' => 'validStepFirst', 'uses' => 'CheckoutController@validStepFirst']);
    Route::post('/api/checkout/validStepSecond',['as' => 'validStepSecond', 'uses' => 'CheckoutController@validStepSecond']);

    /*catalog*/
    Route::get('catalogs/{catalog_alias}', ['as' => 'catalog.show', 'uses' => 'CatalogController@show']);
    Route::get('catalogs', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);

    Route::get('product/search', ['as' => 'product.search', 'uses' => 'ProductController@search']);
    Route::get('rss.xml', ['as' => 'feed', 'uses' => 'ArticleController@feed']);


    Route::get('/', ['as' => 'front', 'uses' => 'FrontController@index']);

    //Auth
    Route::post('api/user/login', 'Auth\LoginController@apiLogin')->name('apiLogin');
    Route::post('api/user/register', 'Auth\RegisterController@apiRegister')->name('apiRegister');
});


Route::group(['prefix' => 'user', 'middleware' => 'web'], function () {


    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', ['as' => 'user.profile', 'uses' => 'Auth\ProfileController@getProfile']);
        Route::get('logout', ['as' => 'user.logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']); //Just added to fix issue

    });
});

Route::get('/home', 'HomeController@index');


