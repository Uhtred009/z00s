<?php

use Illuminate\Http\Request;

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
        'prefix' => 'api',
        'middleware' => 'api',
    ],
    function () {
        Route::post('login', 'AuthController@login');
        Route::post('login/refresh', 'AuthController@refresh');
    }
);

Route::group([
        'namespace' => 'Olymbytes\Z00s\Http\Controllers',
        'middleware' => 'api,auth:api',
    ], function () {
    	Route::post('logout', 'AuthController@logout');
    }
);
