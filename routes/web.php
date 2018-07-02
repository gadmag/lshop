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
    ],
        [
            'except' => ['show']
        ]);

    Route::get('option/{id}', 'ProductController@deleteOption');
    //upload
    Route::get('upload/{id}', 'UploadController@deleteFile');
    Route::get('uploadFile', 'UploadController@uploadFile');
    Route::post('menu/updatesort/', ['as' => 'uploadsort', 'uses' => 'MenuController@updateMenuSort']);

    /**
     * filemanager
     */
    Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');
});

Route::group(['middleware' => 'web'], function () {
//    Route::get('news/{alias}', ['as' => 'news.show', 'uses' => 'ArticleController@show']);

    /*page*/
    Route::get('pages/{page_alias}', ['as' => 'page.show', 'uses' => 'PageController@show']);
    /*product*/
    Route::get('products/{product}', ['as' => 'product.show', 'uses' => 'ProductController@show']);
    Route::get('products', ['as' => 'product.index', 'uses' => 'ProductController@index']);
    Route::get('add-to-cart/{id}', ['as' => 'product.addToCart', 'uses' => 'ProductController@addToCart']);
    Route::get('reduce/{id}', ['as' => 'product.reduceByOne', 'uses' => 'ProductController@getReduceByOne']);
    Route::get('remove/{id}', ['as' => 'product.removeItem', 'uses' => 'ProductController@getRemoveItem']);
    Route::get('add-to-wishlist/{id}', ['as' => 'product.addToWishList', 'uses' => 'ProductController@addToWishList']);
    Route::get('remove-to-wishlist/{id}', ['as' => 'product.removeToWishList', 'uses' => 'ProductController@removeToWishList']);
    Route::get('wishlist', ['as' => 'product.WishList', 'uses' => 'ProductController@getWishList']);
    Route::get('wishlist-json', ['as' => 'product.WishListJson', 'uses' => 'ProductController@getWishListJson']);
    Route::get('shopping-cart', ['as' => 'product.shoppingCart', 'uses' => 'ProductController@getCart']);
    Route::get('shopping-cart-detail', ['as' => 'product.shoppingCartDerail', 'uses' => 'ProductController@getCartDetail']);
    Route::get('/checkout', ['as' => 'checkout', 'uses' => 'ProductController@getCheckout', 'middleware' => 'auth']);
    Route::post('/checkout', ['as' => 'checkout', 'uses' => 'ProductController@postCheckout', 'middleware' => 'auth']);
    /*catalog*/
    Route::get('catalogs/{catalog}', ['as' => 'catalog.show', 'uses' => 'CatalogController@show']);
    Route::get('catalogs', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);


    Route::get('search', 'ArticleController@search');

    Route::get('rss.xml', ['as' => 'feed', 'uses' => 'ArticleController@feed']);


//Route::get('tags/{tags}', 'TagsController@show');
    Route::get('/', ['as' => 'front', 'uses' => 'WelcomeController@index']);
//
//    Route::get('contact', 'WelcomeController@contact');
//    Route::get('about', 'WelcomeController@about');

    Route::get('sendorder', 'SubscriberController@sendOrder');
    Route::get('sendcall', 'SubscriberController@sendBackCall');

});


Route::group(['prefix' => 'user', 'middleware' => 'web'], function () {


    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', ['as' => 'user.profile', 'uses' => 'Auth\ProfileController@getProfile']);
        Route::get('logout', ['as' => 'user.logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']); //Just added to fix issue

    });
});

Route::get('/home', 'HomeController@index');

//Route::group(['prefix'=>'dashboard'], function () {
//
//    //admins
//
//    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
//    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
//    Route::get('/', 'AdminController@index')->name('admin.dashboard');
//
//});

