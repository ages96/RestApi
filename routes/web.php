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
});