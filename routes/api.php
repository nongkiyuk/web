<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('/', function(){
            return response()->json([
                'status' => 'alive', 
                'version' => '0.1',
                'name' => 'Nongkiyuk Api'
                ]);
        });
        
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
        Route::get('places', 'PlaceController@index');

        Route::group(['middleware' => 'auth:api'], function() {
            //user
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');

            //place
            // Route::get('places', 'PlaceController@index');

        });
    });
});
