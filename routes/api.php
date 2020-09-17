<?php

Route::group(['prefix' => 'V1'], function () {

    Route::get('products', 'Api\V1\ProductController@index');

    Route::post('products', 'Api\V1\ProductController@store');

    Route::get('products/{id}', 'Api\V1\ProductController@show');

    Route::put('products/{id}', 'Api\V1\ProductController@update');

    Route::delete('products/{id}', 'Api\V1\ProductController@destroy');

    Route::post('products/search', 'Api\V1\ProductController@search');
});
