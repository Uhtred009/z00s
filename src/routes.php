<?php

/*
|--------------------------------------------------------------------------
| Olymbytes Z00s Routes
|--------------------------------------------------------------------------
|
| //
|
*/

Route::group([
        'namespace' => 'Olymbytes\Z00s\Http\Controllers',
        'prefix' => config('z00s.route_prefix'),
        'middleware' => 'api',
    ],
    function () {
        Route::post('login', 'AuthController@login');
        Route::post('login/refresh', 'AuthController@refresh');
        Route::post('password/email', 'ResetPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'ResetPasswordController@reset');
    }
);

Route::group([
        'namespace' => 'Olymbytes\Z00s\Http\Controllers',
        'prefix' => config('z00s.route_prefix'),
        'middleware' => ['api', 'auth:api'],
    ], function () {
        Route::post('logout', 'AuthController@logout');
    }
);
