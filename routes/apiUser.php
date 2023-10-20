<?php

Route::group(['namespace' => 'User', 'middleware' => ['api'], 'prefix' => $v1Prefix . '/user'], function () {

    // notifications
    Route::get('notifications', 'NotificationController@index');

    // push notifications
    Route::post('pushNotifications', 'PushNotificationController@register');
    Route::post('pushNotifications/send', 'PushNotificationController@send');
});


// secured api using user's access token
Route::group(['namespace' => 'User', 'middleware' => ['api', 'auth:api'], 'prefix' => $v1Prefix . '/user'], function () {

    // apps 
    Route::resource('apps', 'AppsController');

    // settings
    Route::get('settings', 'SettingsController@index');

    // test
    Route::get('test', 'TestController@index');

    //Logout
    Route::post('/logout', 'Auth\APIAuthController@logout');
});
