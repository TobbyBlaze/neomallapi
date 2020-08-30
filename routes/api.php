<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\User;
use App\Seller;
use App\Admin;
use App\Good;
use App\Cart;
use App\Review;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/login', 'Api\AuthController@login')->name('login');
Route::group([ 'prefix' => 'auth'], function (){ 
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'API\AuthController@login');
        // Route::get('login', 'Api\AuthController@login')->name('login');
        Route::post('signup', 'API\AuthController@signup');

        Route::post('seller-login', 'API\AuthController@seller_login');
        Route::post('seller-signup', 'API\AuthController@seller_signup');

        Route::post('admin-login', 'API\AuthController@admin_login');
        Route::post('admin-signup', 'API\AuthController@admin_signup');

        Route::get('/', 'GoodsController@index');
        
    });
    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('logout', 'API\AuthController@logout');
    
        Route::get('getuser', 'API\AuthController@getUser');
    
        //Goods

        // Route::get('home', 'GoodsController@index')->name('home');
        Route::resource('/', 'GoodsController');
        Route::get('products/{id}', 'StoreController@index');
        Route::resource('show', 'GoodsController');
        Route::get('prdetails/{id}', 'GoodsController@show');
        // Route::resource('prdetails', 'GoodsController');
        // Route::resource('show', 'GoodsController');
        Route::resource('review', 'ReviewsController');
        Route::any('storereview/{id}', 'ReviewsController@store');
        Route::resource('shcart', 'CartsController');
        // Route::any('storecart/{id}', 'CartsController@store');
        // Route::any('storecart', 'CartsController@store');
        Route::post('storecart', 'CartsController@store');
        Route::post('storewish', 'WishController@store');
        // Route::any('deletecart/{id}', 'CartsController@destroy');
        Route::any('deletecart', 'CartsController@delete');
        Route::any('clearcart', 'CartsController@clear');
        Route::post('order', 'OrderController@store');
        Route::any ( 'found-all', 'FindController@all');

        // Route::get('prdetails/{id}', 'GoodsController@show');

    });

    Route::group(['middleware' => ['auth:api', 'auth.seller']], function() {
        Route::get('s-logout', 'API\AuthController@seller_logout');
        Route::get('getseller', 'API\AuthController@getSeller');
        Route::resource('/', 'GoodsController');
        Route::post('storegood', 'GoodsController@store');
    });

    Route::group(['middleware' => ['auth:api', 'auth.admin']], function() {
        Route::get('a-logout', 'API\AuthController@admin_logout');
        Route::get('getadmin', 'API\AuthController@getAdmin');
    });

//     Route::group(['middleware' => 'auth:api'], function() {
//         Route::get('logout', 'API\AuthController@logout');
//         Route::get('s-logout', 'API\AuthController@seller_logout');
//         Route::get('getuser', 'API\AuthController@getUser');

//         //Goods

//         // Route::get('home', 'GoodsController@index')->name('home');
//         Route::resource('/', 'GoodsController');
//         Route::resource('show', 'GoodsController');
//         Route::get('prdetails/{id}', 'GoodsController@show');
//         // Route::resource('prdetails', 'GoodsController');
//         // Route::resource('show', 'GoodsController');
//         Route::resource('review', 'ReviewsController');
//         Route::any('storereview/{id}', 'ReviewsController@store');
//         Route::resource('shcart', 'CartsController');
//         // Route::any('storecart/{id}', 'CartsController@store');
//         // Route::any('storecart', 'CartsController@store');
//         Route::post('storecart', 'CartsController@store');
//         Route::any('clearcart', 'CartsController@clear');
//         Route::post('order', 'OrderController@store');
//         Route::any ( 'found-all', 'FindController@all');

//     });
});

Route::get('/', 'GoodsController@index');
Route::get('products/{id}', 'StoreController@index');
Route::get('prdetails/{id}', 'GoodsController@show');

// Route::get('prdetails/{id}', 'GoodsController@show');

// Route::get('home', 'GoodsController@index')->name('home');
// Route::resource('/', 'GoodsController');
// Route::resource('show', 'GoodsController');
// Route::resource('prdetails', 'GoodsController');
// // Route::resource('show', 'GoodsController');
// Route::resource('review', 'ReviewsController');
// Route::any('storereview/{id}', 'ReviewsController@store');
// Route::resource('shcart', 'CartsController');
// Route::any('storecart/{id}', 'CartsController@store');
// Route::any('clearcart', 'CartsController@clear');
// Route::post('order', 'OrderController@store');


