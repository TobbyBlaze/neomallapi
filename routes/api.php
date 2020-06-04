<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\User;
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
        
    });
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('getuser', 'API\AuthController@getUser');

        //Goods

        // Route::get('home', 'GoodsController@index')->name('home');
        Route::resource('/', 'GoodsController');
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
        Route::any('clearcart', 'CartsController@clear');
        Route::post('order', 'OrderController@store');
        Route::any ( 'found-all', 'FindController@all');

    });
});

Route::get('/', 'GoodsController@index');
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


