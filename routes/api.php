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
Route::post('submit_request_partnership', 'API_Controller\StoreController@submit_request_partnership');
Route::post('upline_get_request_partnership', 'API_Controller\StoreController@upline_get_request_partnership');
Route::post('accept_partnership', 'API_Controller\StoreController@accept_partnership');
Route::post('reject_partnership', 'API_Controller\StoreController@reject_partnership');
Route::post('upline_partner_list', 'API_Controller\StoreController@upline_partner_list');
Route::post('downline_partner_list', 'API_Controller\StoreController@downline_partner_list');
Route::post('get_store_detail', 'API_Controller\StoreController@get_store_detail');
Route::post('add_rfq_request', 'API_Controller\TransactionController@add_rfq_request');
Route::post('view_active_rfq_request', 'API_Controller\TransactionController@view_active_rfq_request');
Route::post('seller_get_rfq_request', 'API_Controller\StoreController@get_rfq_request');
Route::post('add_rfq_offer', 'API_Controller\StoreController@add_rfq_offer');
Route::post('add_to_favorite', 'API_Controller\ProductController@add_to_favorite');
Route::post('delete_from_favorite', 'API_Controller\ProductController@delete_from_favorite');
Route::post('my_favorite', 'API_Controller\ProductController@my_favorite');
Route::post('get_user_store_detail', 'API_Controller\StoreController@get_user_store_detail');
Route::post('accept_rfq_offer', 'API_Controller\TransactionController@accept_rfq_offer');
Route::post('close_rfq_request', 'API_Controller\TransactionController@close_rfq_request');
Route::post('rfq_request_history', 'API_Controller\TransactionController@rfq_request_history');
Route::post('financial_history', 'API_Controller\TransactionController@financial_history');
Route::post('rfq_offer_history', 'API_Controller\StoreController@rfq_offer_history');
Route::post('get_new_product_detail', 'API_Controller\ProductController@get_new_product_detail');
Route::post('best_seller_product_detail', 'API_Controller\ProductController@best_seller_product_detail');
Route::post('search', 'API_Controller\ProductController@search');
Route::post('advance_search', 'API_Controller\ProductController@advance_search');
Route::post('get_all_product_detail', 'API_Controller\ProductController@get_all_product_detail');
Route::post('get_sort_by_list', 'API_Controller\MasterDataController@get_sort_by_list');
Route::post('sort_by_asc', 'API_Controller\ProductController@sort_by_asc');
Route::post('sort_by_desc', 'API_Controller\ProductController@sort_by_desc');
Route::post('get_sort_by_id', 'API_Controller\ProductController@get_sort_by_id');
Route::post('get_sort_by_id_store', 'API_Controller\ProductController@get_sort_by_id_store');

Route::post('update_store_information', 'API_Controller\StoreController@update_store_information');

Route::post('update_user_profile', 'API_Controller\UserController@update_user_profile');

Route::post('update_user_image', 'API_Controller\UserController@update_user_image');
Route::post('update_user_password', 'API_Controller\UserController@update_user_password');

Route::post('delete_user_store_courier', 'API_Controller\StoreController@delete_user_store_courier');

Route::post('insert_user_store_courier', 'API_Controller\StoreController@insert_user_store_courier');

Route::post('get_all_store', 'API_Controller\StoreController@get_all_store');
Route::post('update_store_document', 'API_Controller\StoreController@update_store_document');

Route::post('generate_recommendation', 'API_Controller\MasterDataController@generate_recommendation');
Route::post('get_product_by_style', 'API_Controller\ProductController@get_product_by_style');


Route::post('delete_all_product_from_bag', 'API_Controller\TransactionController@delete_all_product_from_bag');

Route::post('dashboard', 'API_Controller\StoreController@dashboard');
Route::post('delete_product', 'API_Controller\ProductController@delete_product');
Route::post('filter_product_store', 'API_Controller\StoreController@filter_product_store');
Route::post('report_product', 'API_Controller\TransactionController@report_product');
Route::post('reject_payment_history', 'API_Controller\TransactionController@reject_payment_history');
Route::post('get_notification', 'API_Controller\TransactionController@get_notification');
Route::post('read_notification', 'API_Controller\TransactionController@read_notification');