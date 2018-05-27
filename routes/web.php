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
Route::group(['middleware' => 'auth.custom'], function () {
    Route::get('test3', 'Web_Controller\TestController@test3');
});
Route::get('login_page', 'Web_Controller\UserController@login_page');
Route::post('login', 'Web_Controller\UserController@login');
Route::post('register', 'Web_Controller\UserController@register');
Route::get('logout', 'Web_Controller\UserController@logout');
Route::get('test', 'Web_Controller\TestController@test');
Route::get('test2', 'Web_Controller\TestController@test2');
//Route::get('test3', 'Web_Controller\TestController@test3');
Route::get('algoritma_ffa_psnn', 'Web_Controller\TestController@algoritma_FFA_PSNN');
Route::get('index', 'Web_Controller\AppController@index');
Route::get('', 'Web_Controller\AppController@index');
Route::get('open_store', 'Web_Controller\AppController@open_store_page');
Route::post('register_store', 'Web_Controller\AppController@register_store');
Route::get('seller_panel', 'Web_Controller\SellerController@seller_panel_dashboard');
Route::get('seller_panel_store_settings', 'Web_Controller\SellerController@seller_panel_store_settings');
Route::get('seller_panel_product', 'Web_Controller\SellerController@seller_panel_product');
Route::post('add_product', 'Web_Controller\SellerController@add_product');

//admin
Route::get('admin_login_page', 'Web_Controller\AdminController@login_page');
Route::post('admin_login', 'Web_Controller\AdminController@login');
Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('admin/logout', 'Web_Controller\AdminController@logout');
    Route::get('admin/', 'Web_Controller\AdminController@manage_store');
    Route::get('admin/manage_store', 'Web_Controller\AdminController@manage_store');
    Route::post('admin/reject_store', 'Web_Controller\AdminController@reject_store');
    Route::post('admin/accept_store', 'Web_Controller\AdminController@accept_store');
    Route::get('admin/manage_user', 'Web_Controller\AdminController@manage_user');
    Route::post('admin/set_nonactive_user', 'Web_Controller\AdminController@set_nonactive_user');
    Route::post('admin/set_active_user', 'Web_Controller\AdminController@set_active_user');
    Route::get('admin/manage_product', 'Web_Controller\AdminController@manage_product');
    Route::post('admin/reject_product', 'Web_Controller\AdminController@reject_product');
    Route::post('admin/accept_product', 'Web_Controller\AdminController@accept_product');
});

Route::post('proses', 'Web_Controller\SellerController@test');
