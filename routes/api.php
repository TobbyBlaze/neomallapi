<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\User;
use App\Seller;
use App\Admin;
use App\Good;
use App\Cart;
use App\Wish;
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
        Route::post('updateUser', 'UserController@updateUser');
    
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

        //Reset password
        // Route::group(['prefix' => 'password'], function () {    
        //     Route::post('create', 'PasswordResetController@create');
        //     Route::get('find/{token}', 'PasswordResetController@find');
        //     Route::post('reset', 'PasswordResetController@reset');
        // });

        //Checkout
        Route::post('/charge', 'CheckoutController@charge');

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

//User Reset password
Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

//Seller Reset password
Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'SellerPasswordResetController@create');
    Route::get('find/{token}', 'SellerPasswordResetController@find');
    Route::post('reset', 'SellerPasswordResetController@reset');
});

//Admin Reset password
Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'AdminPasswordResetController@create');
    Route::get('find/{token}', 'AdminPasswordResetController@find');
    Route::post('reset', 'AdminPasswordResetController@reset');
});

// Account activation
Route::group([
    'prefix' => 'auth'
], function () {
    // Route::post('login', 'AuthController@login');
    // Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::get('sellerSignup/activate/{token}', 'AuthController@sellerSignupActivate');
    Route::get('adminSignup/activate/{token}', 'AuthController@adminSignupActivate');
  
    // Route::group([
    //   'middleware' => 'auth:api'
    // ], function() {
    //     Route::get('logout', 'AuthController@logout');
    //     Route::get('user', 'AuthController@user');
    // });
});

//Goods
Route::get('/', 'GoodsController@index');
Route::get('prdetails/{id}', 'GoodsController@show');

//Stores
Route::get('stores', 'StoreController@index');
Route::get('products/{id}', 'StoreController@show');

//Search
Route::any ( 'searchGoods', 'FindController@goods');
Route::any ( 'searchSellers', 'FindController@sellers');

//Checkout test
Route::post('/charge', 'CheckoutController@charge');


Route::get('location', function () {

    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = request()->ip();

    // $ip = '50.90.0.1';
    // $ip = \Request::ip();
    // $ip = request()->ip();
    $data = \Location::get($ipaddress);
    // dd($data);
    return response()->json($data);
   
});
