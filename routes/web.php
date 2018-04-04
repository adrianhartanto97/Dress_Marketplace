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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login_page', 'Web_Controller\UserController@login_page');
Route::post('login', 'Web_Controller\UserController@login');
Route::post('register', 'Web_Controller\UserController@register');
Route::get('test', 'Web_Controller\TestController@test');
Route::get('test2', 'Web_Controller\TestController@test2');
