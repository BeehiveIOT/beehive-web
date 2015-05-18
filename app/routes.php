<?php

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
    Route::get('templates/{templateId}/devices', ['uses'=>'DeviceController@getByTemplate']);
    Route::get('dashboard/devices/{id}', ['uses' => 'DeviceController@device']);
    Route::get('devices/{id}/commands', ['uses' => 'DeviceController@getCommands']);
    Route::get('devices/{id}/datastreams', ['uses' => 'DeviceController@getDataStreams']);
    Route::post('devices/{id}/commands/{commandId}/execute', ['uses' => 'DeviceController@executeCommand']);
    Route::resource('devices', 'DeviceController', $except);

    // Route used to enable html5 history api with reactjs
    Route::any('dashboard/templates/{all?}', ['uses' => 'TemplateController@page'])
        ->where('all', '.*');
    Route::resource('templates', 'TemplateController', $except);
    Route::resource('templates.commands', 'CommandController', $except);
    Route::resource('templates.commands.arguments', 'ArgumentController', $except);
    Route::resource('templates.datastreams', 'DataStreamController', $except);

    Route::any('dashboard/permissions/{all?}', ['uses'=>'DevicePermissionController@page'])
        ->where('all', '.*');
    Route::resource('devices.permissions', 'DevicePermissionController', $except);

    /**
     * All this is PoC stuff gonna be removed :3
     * TO BE REMOVED
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

/**
 * REST API endpoints
 * Authentication: json web tokens
 */
Route::group(['prefix' => 'api/v1', 'before' => 'cookie-remove'], function() {
    Route::post('auth', ['uses'=>'Controllers\Rest\AuthController@authenticate']);

    Route::group(['before' => 'jwt-auth'], function() {
        Route::resource('devices', 'Controllers\Rest\DeviceController');
        Route::resource('templates', 'Controllers\Rest\TemplateController');
        Route::resource('templates.commands', 'Controllers\Rest\CommandController');
        Route::resource('templates.commands.arguments', 'Controllers\Rest\ArgumentController');
        Route::resource('templates.datastreams', 'Controllers\Rest\DataStreamController');
    });
});

View::composer('profile.edit', 'ViewHelper@getCountries');


/**
 * TO BE REMOVED
 */
Route::get('design', function() {
    // return View::make('home.design');
    return \Carbon\Carbon::now()->timestamp;
});
