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
    Log::info("Superuser: ", Input::all());
    return Response::make('', 400);
});

Route::post('auth/acl', function() {
    Log::info("ACL: ", Input::all());
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
    Route::get('dashboard/devices/{id}', ['uses' => 'DeviceController@device']);
    Route::get('devices/{id}/commands', ['uses' => 'DeviceController@getCommands']);
    Route::get('devices/{id}/datastreams', ['uses' => 'DeviceController@getDataStreams']);
    Route::resource('devices', 'DeviceController', $except);

    Route::get('dashboard/templates', ['uses'=>'TemplateController@page']);
    Route::resource('templates', 'TemplateController', $except);

    Route::resource('templates.commands', 'CommandController', $except);

    Route::resource('templates.commands.arguments', 'ArgumentController', $except);

    /**
     * All this is PoC stuff gonna be removed :3
     */
    Route::get('real-time', function() {
        return View::make('home.real');
    });
    Route::post('real-time/publish-command', ['uses' => 'RealTimeController@publishCommand']);

    Route::get('mqtt-publish', function() {
        $topic = Input::get('topic');
        $message = Input::get('message');
        $body = [
            'topic' => $topic,
            'message' => $message
        ];

        $a = \Httpful\Request::post('http://localhost:9999/mqtt/publish')
        ->sendsJson()
        ->body(json_encode($body))
        ->send();

        return $a;
    });

});
Route::get('design', function() {
    // return View::make('home.design');
    return \Carbon\Carbon::now()->timestamp;
});

Route::group(['prefix' => 'api/v1'], function() {
    Route::group(['before' => 'rest_auth'], function() {
        Route::post('auth', ['uses'=>'Controllers\Rest\AuthController@auth']);

    });
});

View::composer('profile.edit', 'ViewHelper@getCountries');
