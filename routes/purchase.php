<?php

use Illuminate\Support\Facades\Route;

/*--------------------------Supplier---------------------------------------*/

Route::post('/supplier', 'Purchase\SupplierController@index');
Route::post('/store_supplier', 'Purchase\SupplierController@store');
Route::post('/update_supplier/{id}', 'Purchase\SupplierController@update');
Route::post('/supplier/{id}', 'Purchase\SupplierController@edit');
Route::post('/delete_supplier/{id}', 'Purchase\SupplierController@destroy');
Route::post('/suppliersearch', 'Purchase\SupplierController@search');
Route::post('/supplier/supplier_account_list/{id}', 'Purchase\SupplierController@show');
Route::post('/SupplierExport', 'Purchase\SupplierController@Export');
Route::post('/SupplierImport', 'Purchase\SupplierController@Import');


/*------------------------------------------------purchase----------------------------------*/

Route::post('/purchase/newpurchase', 'Purchase\PurchaseController@index');
Route::post('/Purchase/delete', 'Purchase\PurchaseController@destroy');
Route::post('/Purchase/delete/{id}', 'Purchase\PurchaseController@destroy');
Route::post('/purchase/newpurchasesearch', 'Purchase\PurchaseController@search');
Route::post('/listpurchase', 'Purchase\PurchaseController@show');
Route::post('/listpurchasesearch', 'Purchase\PurchaseController@search');
Route::post('/add_Purchase', 'Purchase\PurchaseController@store');
Route::post('/payPurchase', 'Purchase\purchaseController@payment');
Route::post('/purchase_details/{id}', 'Purchase\PurchaseController@details');
Route::post('/purchase_daily/{id}', 'Purchase\PurchaseController@purchase_daily');
// ------------------------------------------------------------------------------------------
Route::post('/purchase_details_in_return/{id}', 'Purchase\PurchaseReturnController@details');
Route::post('/purchase_return_details/{id}', 'Purchase\PurchaseReturnController@index');
Route::post('/purchasereturn', 'Purchase\PurchaseReturnController@create');
Route::post('/listreturn_purchase/{id}', 'Purchase\PurchaseReturnController@show');
Route::post('/listreturn_purchasesearch', 'Purchase\PurchaseReturnController@search');
Route::post('/returnpurchase_details/{id}', 'Purchase\PurchaseReturnController@return_detail');
Route::post('/invoice_purchase/{id}', 'Purchase\PurchaseController@invoice_purchase');
Route::post('/invoice_return_purchase/{id}', 'Purchase\PurchaseReturnController@return_invoice');
Route::post('/payment_bond/{id}', 'Purchase\PaymentBondController@payment_bond');
Route::post('/payment_bond_list', 'Purchase\PaymentBondController@paymentBondlist');
Route::post('/data_for_payment_bond/{id}', 'Purchase\PaymentBondController@payment_bond');
Route::post('/store_PaymentBond', 'Purchase\PaymentBondController@store_PaymentBond');



// Route::post('/payment_bond', 'PayableNoteController@index');
// Route::post('/payment_bond_list', 'PayableNoteController@paymentBondlist');
// Route::post('/payment_bond_store/{id}', 'PayableNoteController@store');

