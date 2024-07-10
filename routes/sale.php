<?php

use Illuminate\Support\Facades\Route;


Route::post('/sale/newsale', 'Sale\SaleController@index');
Route::post('/sale/newsale/{id}', 'Sale\SaleController@index');
Route::post('/listsale', 'Sale\SaleController@show');
Route::post('/listsalesearch', 'Sale\SaleController@search');
Route::post('/add_Sale', 'Sale\SaleController@store');
Route::post('/paySale', 'Sale\SaleController@payment');
Route::post('/sale_details/{id}', 'Sale\SaleController@details');
Route::post('/sale_daily/{id}', 'Sale\SaleController@sale_daily');
Route::post('/return_sale_daily/{id}', 'Sale\SaleReturnController@return_sale_daily');
Route::post('/sale_return_details/{id}', 'Sale\SaleReturnController@index');

Route::post('/Sale/delete', 'Sale\SaleController@destroy');
Route::post('/Sale/delete/{id}', 'Sale\SaleController@destroy');
Route::post('/sale_invoice/{id}', 'Sale\SaleController@invoice_sale');
Route::post('/return_sale_invoice/{id}', 'Sale\SaleReturnController@return_invoice');

// Route::post('/data_for_receivable_bond/{id}', 'Sale\SaleController@receivable_bond');
Route::post('/sale_details_in_return/{id}', 'Sale\SaleReturnController@details');
Route::post('/salereturn', 'Sale\SaleReturnController@create');
Route::post('/listreturn_sale/{id}', 'Sale\SaleReturnController@show');

Route::post('/returnsale_details/{id}', 'Sale\SaleReturnController@return_detail');

Route::post('/receivable_bond/{id}', 'Sale\ReceivableBondController@receivable_bond');
Route::post('/receivable_bond_daily/{id}', 'Sale\ReceivableBondController@receivable_bond_daily');

Route::post('/get_receivable_bond', 'Sale\ReceivableBondController@get_receivable_bond');
Route::post('/receivable_bond_list', 'Sale\ReceivableBondController@receivableBondlist');
Route::post('/data_for_receivable_bond/{id}', 'Sale\ReceivableBondController@receivable_bond');
Route::post('/store_ReceivableBond', 'Sale\ReceivableBondController@store_ReceivableBond');
Route::post('/get_sale_account_setting', 'Sale\SaleController@get_sale_account_setting');





