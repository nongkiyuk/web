<?php

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

Route::namespace('Web')->group(function () {

    Route::get('login', 'AuthController@showFormLogin');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::middleware(['auth:admins'])->group(function () {
        //Places
        Route::get('/', 'PlaceController@index')->name('index');
        Route::get('/place/new', 'PlaceController@create')->name('place.create');
        Route::post('/place/new', 'PlaceController@store')->name('place.store');
        Route::get('/place/{id}/detail', 'PlaceController@show')->name('place.show');
        Route::get('/place/{id}/edit', 'PlaceController@edit')->name('place.edit');
        Route::post('/place/{id}/update', 'PlaceController@update')->name('place.update');
        Route::post('/place/{id}/delete', 'PlaceController@destroy')->name('place.destroy');

        //Place Images
        Route::get('/place/{id}/images', 'PlaceController@image')->name('place.images');
        Route::post('/place/{id}/images', 'PlaceController@uploadImage')->name('place.images');
        Route::get('/place/{placeId}/images/{imageId}/delete', 'PlaceController@destroyImage')->name('place.image.destroy');
        Route::get('/place/{placeId}/images/{imageId}/cover', 'PlaceController@coverImage')->name('place.image.cover');


        //Users
        Route::get('/users', 'UserController@index')->name('user.index');
        Route::get('/user/new', 'UserController@create')->name('user.create');
        Route::post('/user/new', 'UserController@store')->name('user.store');
        Route::get('/user/{id}/detail', 'UserController@show')->name('user.show');
        Route::get('/user/{id}/edit', 'UserController@edit')->name('user.edit');
        Route::post('/user/{id}/update', 'UserController@update')->name('user.update');
        Route::post('/user/{id}/delete', 'UserController@destroy')->name('user.destroy');
        Route::get('/user/{id}/switch', 'UserController@switch')->name('user.switch');
        //User Favotire Place
        Route::post('/user/{id}/places', 'UserController@showPlaces')->name('user.place');
        
        //Notification
        Route::get('/notification', 'NotificationController@index')->name('notification.index');
    });

});
