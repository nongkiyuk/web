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
        Route::get('place/{id}/detail', 'PlaceController@detail');

        Route::group(['middleware' => 'auth:api'], function() {
            //user
            Route::delete('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
            Route::patch('user', 'AuthController@update');
            Route::post('user/picture', 'AuthController@changePicture');

            //place
            // Route::get('places', 'PlaceController@index');
            Route::get('place/{id}', 'PlaceController@checkFavorite');
            Route::post('place/{id}/favorite', 'PlaceController@addToFavorite');
            Route::delete('place/{id}/favorite', 'PlaceController@deleteFromFavorite');
            Route::get('places/favorite', 'PlaceController@getListFavorite');

        });
    });
});
