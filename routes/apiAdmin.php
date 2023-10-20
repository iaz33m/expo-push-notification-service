<?php

// APIS only for admin panel

Route::group(['namespace' => 'Admin', 'middleware' => ['api', 'auth:api'], 'prefix' => $v1Prefix . '/admin'], function () {

    // For testing only
    Route::get('users', 'UserController@index');



    // settings
    Route::get('settings', 'AdminSettingsController@index');
    Route::put('settings', 'AdminSettingsController@edit');

    // metadata
    Route::get('metaData', 'AdminSiteDataController@index');

    // push notification
    Route::post('pushNotifications', 'AdminPushNotificationController@send');

    // settings
    Route::post('settings', '\App\Http\Controllers\User\SettingsController@update');

    // permissions
    Route::get('permissions', 'AdminPermissionController@index');
    Route::get('permissions/role/{id}', 'AdminPermissionController@rolePermissions');
    Route::get('permissions/user/{id}', 'AdminPermissionController@userPermissions');
    Route::post('permissions', 'AdminPermissionController@create');
    Route::patch('permissions/role/{id}', 'AdminPermissionController@updatePermissions');

    // Role
    Route::get('roles', 'AdminRoleController@index');
    Route::get('roles/user/{id}', 'AdminRoleController@userRoles');
    Route::post('roles', 'AdminRoleController@create');
    Route::patch('roles/user/{id}', 'AdminRoleController@updateRoles');

});
