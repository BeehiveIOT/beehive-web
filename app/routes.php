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

Route::post('auth/user', function() {
    Log::info("Auth: ", Input::all());
    return Response::make('', 200);
});

Route::post('auth/superuser', function() {
    // TODO: superuser validation will be answer bad request
    // as if there is a superuser it will not need ACL check
    return Response::make('', 400);
});

Route::post('auth/acl', function() {
    return Response::make('', 200);
});

Route::group(['before'=>'auth'], function() {
    $except = ['except'=>['create','edit']];

    Route::get('dashboard', ['uses'=>'DashboardController@index']);
    Route::get('profile', ['uses'=>'UserController@index']);
    Route::get('profile/edit', ['uses'=>'UserController@edit']);
    Route::post('profile/edit', ['uses'=>'UserController@doEdit']);
    Route::post('profile/changepassword', ['uses'=>'UserController@doChangePassword']);
    Route::get('user/{username}', ['uses'=>'UserController@get']);
    Route::post('profile/upload', ['uses' => 'UserController@uploadImage']);

    Route::get('dashboard/devices', ['uses' => 'DeviceController@page']);
    Route::resource('devices', 'DeviceController', $except);

    Route::get('dashboard/templates', ['uses'=>'TemplateController@page']);
    Route::resource('templates', 'TemplateController', $except);

    Route::resource('templates.commands', 'CommandController', $except);

    Route::resource('commands.arguments', 'ArgumentController', $except);

    /**
     * All this is PoC stuff gonna be removed :3
     */
    Route::get('real-time', function() {
        return View::make('home.real');
    });

});
Route::get('design', function() {
    return View::make('home.design');
});


View::composer('profile.edit', 'ViewHelper@getCountries');
