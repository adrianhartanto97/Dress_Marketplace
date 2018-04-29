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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', 'API_Controller\UserController@register');
Route::post('login', 'API_Controller\UserController@login');
Route::post('get_auth_user', 'API_Controller\UserController@getAuthUser');
Route::post('check_store_name', 'API_Controller\StoreController@check_store_name');
Route::post('register_store_name', 'API_Controller\StoreController@register_store_name');
