<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['uses'=>'HomeController@index']);
Route::get('login', ['uses'=>'HomeController@login']);
Route::post('login', ['uses'=>'HomeController@doLogin']);
Route::post('logout', ['uses'=>'HomeController@doLogout']);
Route::get('register', ['uses'=>'HomeController@register']);
Route::post('register', ['uses'=>'HomeController@doRegister']);

Route::group(['before'=>'auth'], function() {
    Route::get('dashboard', ['uses'=>'DashboardController@index']);
    Route::get('profile', ['uses'=>'UserController@index']);
    Route::get('profile/edit', ['uses'=>'UserController@edit']);
    Route::post('profile/edit', ['uses'=>'UserController@doEdit']);
    Route::post('profile/changepassword', ['uses'=>'UserController@doChangePassword']);
    Route::get('user/{username}', ['uses'=>'UserController@get']);
    Route::post('profile/upload', ['uses' => 'UserController@uploadImage']);

    Route::get('models/{id}/json', ['uses'=>'DeviceController@getJson']);
    Route::get('models/create', ['uses'=>'DeviceController@create']);
    Route::post('models', ['uses'=>'DeviceController@doCreate']);
    Route::get('models/{id}/edit', ['uses'=>'DeviceController@edit']);
    Route::put('models/{id}', ['uses'=>'DeviceController@doEdit']);
});


View::composer('profile.edit', 'ViewHelper@getCountries');
View::composer('device.create', 'ViewHelper@getCommunicationTypes');
