<?php

use Illuminate\Support\Facades\Route;

Route::post('/customer', 'Sale\CustomerController@index');
Route::post('/customer/customer_account_list/{id}', 'Sale\CustomerController@show');
Route::post('/store_customer', 'Sale\CustomerController@store');

// ----------
Route::post('/get_customer_account_setting', 'Sale\CustomerController@get_customer_account_setting');
Route::post('/store_customer_account_setting', 'Sale\CustomerController@store_customer_account_setting');


// ---------------------------------customerGroup------------------
Route::post('/customer_groups', 'Sale\CustomerGroupController@index');
Route::post('/store_customer_group', 'Sale\CustomerGroupController@store');


