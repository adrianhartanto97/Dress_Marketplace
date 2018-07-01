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
Route::post('get_purchase_payment', 'API_Controller\TransactionController@get_purchase_payment');
Route::post('confirm_payment', 'API_Controller\TransactionController@confirm_payment');
Route::post('seller_get_order', 'API_Controller\StoreController@seller_get_order');
Route::post('get_order_status', 'API_Controller\TransactionController@get_order_status');
Route::post('approve_order_product', 'API_Controller\StoreController@approve_order_product');
Route::post('seller_get_shipping_confirmation', 'API_Controller\StoreController@seller_get_shipping_confirmation');
Route::post('input_receipt_number', 'API_Controller\StoreController@input_receipt_number');
Route::post('finish_shipping', 'API_Controller\StoreController@finish_shipping');
Route::post('get_receipt_confirmation', 'API_Controller\TransactionController@get_receipt_confirmation');
Route::post('confirm_receipt', 'API_Controller\TransactionController@confirm_receipt');
Route::post('add_to_wishlist', 'API_Controller\ProductController@add_to_wishlist');
Route::post('delete_from_wishlist', 'API_Controller\ProductController@delete_from_wishlist');
Route::post('my_wishlist', 'API_Controller\ProductController@my_wishlist');
Route::post('withdraw', 'API_Controller\TransactionController@withdraw');
Route::post('get_review_rating', 'API_Controller\TransactionController@get_review_rating');
Route::post('submit_review_rating', 'API_Controller\TransactionController@submit_review_rating');
Route::post('transaction_history', 'API_Controller\TransactionController@transaction_history');
Route::post('get_request_partnership', 'API_Controller\StoreController@get_request_partnership');