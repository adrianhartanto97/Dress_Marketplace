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
    Route::get('open_store', 'Web_Controller\AppController@open_store_page');
    Route::post('register_store', 'Web_Controller\AppController@register_store');
    Route::get('seller_panel', 'Web_Controller\SellerController@seller_panel_dashboard');
    Route::get('seller_panel_store_settings', 'Web_Controller\SellerController@seller_panel_store_settings');
    Route::get('seller_panel_product', 'Web_Controller\SellerController@seller_panel_product');

    Route::post('add_product', 'Web_Controller\SellerController@add_product');
    
    Route::post('add_to_bag', 'Web_Controller\AppController@add_to_bag');
    Route::get('view_shopping_bag', 'Web_Controller\AppController@view_shopping_bag');
    Route::post('delete_product_from_bag', 'Web_Controller\AppController@delete_product_from_bag');
    Route::get('checkout', 'Web_Controller\AppController@checkout_page');
    Route::get('checkout_courier_page', 'Web_Controller\AppController@get_checkout_courier_page');
    Route::post('do_checkout', 'Web_Controller\AppController@checkout');
    Route::get('checkout_success', 'Web_Controller\AppController@checkout_success');
    Route::get('purchase', 'Web_Controller\AppController@get_purchase_page');
    Route::post('confirm_payment', 'Web_Controller\AppController@confirm_payment');
    Route::get('seller_panel_sales_order', 'Web_Controller\SellerController@sales_order');
    Route::post('approve_order_product', 'Web_Controller\SellerController@approve_order_product');
    Route::post('input_receipt_number', 'Web_Controller\SellerController@input_receipt_number');
    Route::post('finish_shipping', 'Web_Controller\SellerController@finish_shipping');
    Route::post('confirm_receipt', 'Web_Controller\AppController@confirm_receipt');
    Route::post('submit_review_rating', 'Web_Controller\AppController@submit_review_rating');
    Route::get('transaction_history', 'Web_Controller\AppController@transaction_history');
    Route::get('seller_panel_partnership', 'Web_Controller\SellerController@partnership');
    Route::post('submit_request_partnership', 'Web_Controller\SellerController@submit_request_partnership');
    Route::post('accept_partnership', 'Web_Controller\SellerController@accept_partnership');
    Route::post('reject_partnership', 'Web_Controller\SellerController@reject_partnership');
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

Route::get('product_detail/{product_id}', 'Web_Controller\AppController@product_detail');

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
    Route::get('admin/verify_payment', 'Web_Controller\AdminController@verify_payment');
    Route::post('admin/accept_payment', 'Web_Controller\AdminController@accept_payment');
    Route::post('admin/reject_payment', 'Web_Controller\AdminController@reject_payment');
    Route::get('admin/manage_ffa_psnn', 'Web_Controller\AdminController@manage_ffa_psnn');
    Route::post('admin/submit_training', 'Web_Controller\AdminController@submit_training');
    Route::post('admin/submit_testing', 'Web_Controller\AdminController@submit_testing');
    Route::post('admin/generate_recommendation_api', 'Web_Controller\AdminController@generate_recommendation_api');
});

Route::post('proses', 'Web_Controller\SellerController@test');

Route::post('add_to_wishlist', 'Web_Controller\App2Controller@add_to_wishlist');
Route::post('delete_from_wishlist', 'Web_Controller\App2Controller@delete_from_wishlist');
Route::get('my_wishlist', 'Web_Controller\App2Controller@my_wishlist');
Route::get('balance_detail', 'Web_Controller\App2Controller@withdraw');
Route::post('balance_detail', 'Web_Controller\App2Controller@withdraw');

Route::post('balance_withdraw', 'Web_Controller\App2Controller@balance_withdraw');

Route::get('favorite_store', 'Web_Controller\App2Controller@favorite_store');

Route::get('search', 'Web_Controller\App2Controller@search');
Route::post('search', 'Web_Controller\App2Controller@search');

// Route::match(['get', 'post'], '/', function () {
//     //
// });

Route::get('store_detail/{store_id}', 'Web_Controller\App2Controller@store_detail');
Route::get('request_for_quotation', 'Web_Controller\App2Controller@request_for_quotation');
Route::post('request_for_quotation', 'Web_Controller\App2Controller@add_rfq');

Route::get('seller_panel_request_for_quotation', 'Web_Controller\App2Controller@seller_panel_request_for_quotation');

Route::post('add_to_favorite', 'Web_Controller\App2Controller@add_to_favorite');
Route::post('delete_from_favorite', 'Web_Controller\App2Controller@delete_from_favorite');
Route::get('my_favorite', 'Web_Controller\App2Controller@my_favorite');

Route::get('rfq_request_list', 'Web_Controller\App2Controller@get_rfq_request_list');
Route::post('add_rfq_offer', 'Web_Controller\App2Controller@add_rfq_offer');
Route::post('accept_rfq_offer', 'Web_Controller\App2Controller@accept_rfq_offer');
Route::post('close_rfq_request', 'Web_Controller\App2Controller@close_rfq_request');


Route::post('get_new_product_detail', 'Web_Controller\AppController@get_new_product_detail');
Route::post('best_seller_product_detail', 'Web_Controller\AppController@best_seller_product_detail');

Route::get('filter', 'Web_Controller\App2Controller@filter');
Route::post('filter', 'Web_Controller\App2Controller@filter');

Route::post('update_store_information', 'Web_Controller\App2Controller@update_store_information');
