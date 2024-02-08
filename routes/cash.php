<?php

use Illuminate\Support\Facades\Route;

Route::post('/store_customer', 'Cash\CustomerController@store');
Route::post('/cash/newcash', 'Cash\CashController@index');
Route::post('/cash/newcash/{id}', 'Cash\CashController@index');
Route::post('/listcash', 'Cash\CashController@show');
Route::post('/listcashsearch', 'Cash\CashController@search');
Route::post('/add_Cash', 'Cash\CashController@store');
Route::post('/payCash', 'Cash\CashController@payment');
Route::post('/cash_details/{id}', 'Cash\CashController@details');
Route::post('/cash_daily/{id}', 'Cash\CashController@cash_daily');
Route::post('/cash_return_details/{id}', 'Cash\CashReturnController@index');
Route::post('/Cash/delete', 'Cash\CashController@destroy');
Route::post('/Cash/delete/{id}', 'Cash\CashController@destroy');
Route::post('/invoice_cash/{id}', 'Cash\CashController@invoice_cash');
// Route::post('/data_for_receivable_bond/{id}', 'Cash\CashController@receivable_bond');
// Route::post('/store_ReceivableBond', 'Cash\CashController@store_ReceivableBond');
Route::post('/cash_details_in_return/{id}', 'Cash\CashReturnController@details');
Route::post('/cashreturn', 'Cash\CashReturnController@create');
Route::post('/listreturn_cash/{id}', 'Cash\CashReturnController@show');
Route::post('/returncash_details/{id}', 'Cash\CashReturnController@return_detail');
Route::post('/invoice_return_cash/{id}', 'Cash\CashReturnController@return_invoice');


