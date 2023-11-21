<?php

use Illuminate\Support\Facades\Route;

Route::post('/customer', 'Sale\CustomerController@index');
Route::post('/store_customer', 'Sale\CustomerController@store');
Route::post('/sale/newsale', 'Sale\SaleController@index');
Route::post('/sale/newsale/{id}', 'Sale\SaleController@index');
Route::post('/listsale', 'Sale\SaleController@show');
Route::post('/listsalesearch', 'Sale\SaleController@search');
Route::post('/add_Sale', 'Sale\SaleController@store');
Route::post('/paySale', 'Sale\SaleController@payment');
Route::post('/sale_details/{id}', 'Sale\SaleController@details');
Route::post('/sale_return_details/{id}', 'Sale\SaleReturnController@index');

Route::post('/Sale/delete', 'Sale\SaleController@destroy');
Route::post('/Sale/delete/{id}', 'Sale\SaleController@destroy');

Route::post('/invoice_sale/{id}', 'Sale\SaleController@invoice_sale');

Route::post('/sale_details_in_return/{id}', 'Sale\SaleReturnController@details');
Route::post('/salereturn', 'Sale\SaleReturnController@create');
Route::post('/listreturn_sale/{id}', 'Sale\SaleReturnController@show');

Route::post('/returnsale_details/{id}', 'Sale\SaleReturnController@return_detail');

Route::post('/invoice_return_sale/{id}', 'Sale\SaleReturnController@return_invoice');
