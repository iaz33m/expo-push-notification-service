<?php

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


$v1Prefix = 'v1/{locale}';

include base_path('routes/apiAdmin.php');

include base_path('routes/apiUser.php');

include base_path('routes/apiPublic.php');
