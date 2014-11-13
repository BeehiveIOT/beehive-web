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

    Route::get('devices/json', ['uses'=>'DeviceController@items']);
    Route::resource('devices', 'DeviceController');

    Route::get('templates/json', ['uses'=>'TemplateController@items']);
    Route::resource('templates', 'TemplateController');

    Route::resource('templates.commands', 'CommandController');

    Route::resource('commands.arguments', 'ArgumentController');
});


View::composer('profile.edit', 'ViewHelper@getCountries');
