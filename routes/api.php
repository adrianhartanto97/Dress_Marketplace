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
Route::post('test', 'API_Controller\TestController@test');

Route::post('register', 'API_Controller\UserController@register');
Route::post('login', 'API_Controller\UserController@login');
Route::post('get_auth_user', 'API_Controller\UserController@getAuthUser');
Route::post('get_user_store', 'API_Controller\StoreController@get_user_store');
Route::post('check_store_name', 'API_Controller\StoreController@check_store_name');
Route::post('register_store_name', 'API_Controller\StoreController@register_store_name');
Route::post('get_province_list', 'API_Controller\MasterDataController@get_province_list');
Route::post('get_city_by_province', 'API_Controller\MasterDataController@get_city_by_province');
Route::post('get_courier_list', 'API_Controller\MasterDataController@get_courier_list');
Route::post('get_dress_attributes', 'API_Controller\MasterDataController@get_dress_attributes');
Route::post('register_store', 'API_Controller\StoreController@register_store');
Route::post('add_product', 'API_Controller\StoreController@add_product');
Route::post('get_product_detail', 'API_Controller\ProductController@get_product_detail');
Route::post('add_to_bag', 'API_Controller\TransactionController@add_to_bag');
Route::post('view_shopping_bag', 'API_Controller\TransactionController@view_shopping_bag');
Route::post('delete_product_from_bag', 'API_Controller\TransactionController@delete_product_from_bag');
Route::post('get_checkout_info', 'API_Controller\TransactionController@get_checkout_info');
Route::post('checkout', 'API_Controller\TransactionController@checkout');
