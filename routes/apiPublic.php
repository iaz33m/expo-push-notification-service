<?php

// public api

Route::group(['namespace' => 'Auth', 'middleware' => 'api', 'prefix' => $v1Prefix], function () {

    // Auth routes
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/socialLogin', 'AuthController@socialLogin');

});
