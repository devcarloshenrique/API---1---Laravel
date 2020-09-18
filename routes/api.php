<?php

Route::post('auth', 'Auth\AuthApiController@authenticate');
Route::post('auth-refresh', 'Auth\AuthApiController@refreshToken');

Route::group(['prefix' => 'V1'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::get('products', 'Api\V1\ProductController@index');

        Route::post('products', 'Api\V1\ProductController@store');

        Route::get('products/{id}', 'Api\V1\ProductController@show');

        Route::put('products/{id}', 'Api\V1\ProductController@update');

        Route::delete('products/{id}', 'Api\V1\ProductController@destroy');

        Route::post('products/search', 'Api\V1\ProductController@search');
    });
});

Route::get('products/search', 'Api\V1\ProductController@search')->middleware('jwt.auth');
