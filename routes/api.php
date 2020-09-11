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

use Stevebauman\Location\Facades\Location;

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

Route::group([ 'prefix' => 'auth'], function (){ 
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'API\AuthController@login');
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
        Route::get('profile', 'UserController@index');
        Route::get('updateUser', 'UserController@updateUser');
    
        //Goods
        Route::get('stores', 'StoreController@index');
        Route::get('products/{id}', 'StoreController@show');
        Route::resource('show', 'GoodsController');

        //Reviews
        Route::resource('review', 'ReviewsController');
        Route::any('storereview/{id}', 'ReviewsController@store');
        Route::any('updatereview/{id}', 'ReviewsController@update');
        Route::any('deletereview/{id}', 'ReviewsController@destroy');

        //Carts
        Route::resource('shcart', 'CartsController');
        Route::post('storecart', 'CartsController@store');
        Route::post('deletecart/{id}', 'CartsController@destroy');
        Route::post('clearcart/{id}', 'CartsController@clear');

        //Wishes
        Route::resource('shwish', 'WishController');
        Route::post('storewish', 'WishController@store');
        Route::post('deletewish/{id}', 'WishController@destroy');
        Route::post('clearwish/{id}', 'WishController@clear');

        //Orders
        Route::post('order', 'OrderController@store');

        
        //Ads
        // Route::resource('ads', 'AdsController');
        Route::get('ads', 'AdsController@index');
        Route::get('ads/{id}', 'AdsController@show');
        Route::post('adsCreate', 'AdsController@store');
        Route::any('adsUpdate/{id}', 'AdsController@update');
        Route::any('adsDelete/{id}', 'AdsController@destroy');

    });

    //Seller
    Route::group(['middleware' => ['auth:api', 'auth.seller']], function() {
        Route::get('s-logout', 'API\AuthController@seller_logout');
        Route::get('getseller', 'API\AuthController@getSeller');
        Route::get('profile', 'UserController@index');
        Route::get('updateSeller', 'UserController@updateSeller');

        Route::resource('/', 'GoodsController');
        Route::post('storegood', 'GoodsController@store');
        Route::any('updategood/{id}', 'GoodsController@update');
        Route::any('deletegood/{id}', 'GoodsController@destroy');
        
    });

    //Admin
    Route::group(['middleware' => ['auth:api', 'auth.admin']], function() {
        Route::get('a-logout', 'API\AuthController@admin_logout');
        Route::get('getadmin', 'API\AuthController@getAdmin');
    });

});

Route::get('/', 'GoodsController@index');
Route::get('prdetails/{id}', 'GoodsController@show');

Route::get('stores', 'StoreController@index');
Route::get('products/{id}', 'StoreController@show');

//Search
Route::any ( 'search', 'FindController@all');


Route::get('location', function () {

    $ip = '50.90.0.1';
    // $ip = \Request::ip();
    // $ip = request()->ip();
    $data = \Location::get($ip);
    // dd($data);
    return response()->json($data);
   
});
