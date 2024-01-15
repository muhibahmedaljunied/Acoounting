<?php

use Illuminate\Support\Facades\Route;

/*--------------------------Supplier---------------------------------------*/
Route::post('/store_supplier', 'Supply\SupplierController@store');
Route::post('/update_supplier/{id}', 'Supply\SupplierController@update');
Route::post('/supplier/{id}', 'Supply\SupplierController@edit');
Route::post('/delete_supplier/{id}', 'Supply\SupplierController@destroy');
Route::post('/suppliersearch', 'Supply\SupplierController@search');
Route::post('/SupplierExport', 'Supply\SupplierController@Export');
Route::post('/SupplierImport', 'Supply\SupplierController@Import');
/*------------------------------------------------supply----------------------------------*/
Route::post('/supply/newsupply', 'Supply\SupplyController@index');
Route::post('/Supply/delete', 'Supply\SupplyController@destroy');
Route::post('/Supply/delete/{id}', 'Supply\SupplyController@destroy');
Route::post('/supply/newsupplysearch', 'Supply\SupplyController@search');
Route::post('/listsupply', 'Supply\SupplyController@show');
Route::post('/listsupplysearch', 'Supply\SupplyController@search');
Route::post('/add_Supply', 'Supply\SupplyController@store');
Route::post('/paySupply', 'Supply\supplyController@payment');
Route::post('/supply_details/{id}', 'Supply\SupplyController@details');
Route::post('/supply_daily/{id}', 'Supply\SupplyController@supply_daily');
Route::post('/data_for_payment_bond/{id}', 'Supply\PaymentBondController@payment_bond');
Route::post('/store_PaymentBond', 'Supply\SupplyController@store_PaymentBond');
Route::post('/payment_bond_list', 'Supply\SupplyController@paymentBondlist');

// ------------------------------------------------------------------------------------------
Route::post('/supply_details_in_return/{id}', 'Supply\SupplyReturnController@details');
Route::post('/supply_return_details/{id}', 'Supply\SupplyReturnController@index');
Route::post('/supplyreturn', 'Supply\SupplyReturnController@create');
Route::post('/listreturn_supply/{id}', 'Supply\SupplyReturnController@show');
Route::post('/listreturn_supplysearch', 'Supply\SupplyReturnController@search');
Route::post('/returnsupply_details/{id}', 'Supply\SupplyReturnController@return_detail');
Route::post('/invoice_supply/{id}', 'Supply\SupplyController@invoice_supply');
Route::post('/invoice_return_supply/{id}', 'Supply\SupplyReturnController@return_invoice');
Route::post('/payment_bond/{id}', 'Supply\SupplyController@payment_bond');

