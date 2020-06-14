<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    
    // User
	Route::prefix('container')->group(function () {
    	Route::get('/getParent', 'ContainerController@getSetting');
    	Route::get('/getContainer', 'ContainerController@getContainer');
    	Route::post('/add', 'ContainerController@add');

    	// Setting
		Route::prefix('parent')->group(function () {
	    	Route::post('/add', 'ContainerController@addSetting');
		});
	});



	// Store
	Route::prefix('product')->group(function () {
		Route::post('/add', 'ProductController@add');
		Route::post('/addStock', 'ProductController@addStock');
    	Route::get('/get', 'ProductController@get');
    	Route::get('/detail', 'ProductController@getDetail');
    	Route::post('/order', 'ProductController@order');
	});

	// Store
	Route::prefix('transaction')->group(function () {
    	Route::get('/detail', 'ProductController@getTrans');
	});

});