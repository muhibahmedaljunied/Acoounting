<?php

use Illuminate\Support\Facades\Route;
/*--------------------------Supplier---------------------------------------*/

Route::post('/supplier', 'Purchase\SupplierController@index');
Route::post('/supplier_group', 'Purchase\SupplierController@index');

Route::post('/store_supplier', 'Purchase\SupplierController@store');
Route::post('/update_supplier/{id}', 'Purchase\SupplierController@update');
Route::post('/supplier/{id}', 'Purchase\SupplierController@edit');
Route::post('/delete_supplier/{id}', 'Purchase\SupplierController@destroy');
Route::post('/suppliersearch', 'Purchase\SupplierController@search');
Route::post('/supplier/supplier_account_list/{id}', 'Purchase\SupplierController@show');
Route::post('/SupplierExport', 'Purchase\SupplierController@Export');
Route::post('/SupplierImport', 'Purchase\SupplierController@Import');

/*--------------------------Supplier---------------------------------------*/

Route::post('/supplier_groups', 'Purchase\SupplierGroupController@index');
Route::post('/store_supplier_group', 'Purchase\SupplierGroupController@index');
Route::post('/get_supplier_account_setting', 'Purchase\SupplierController@get_supplier_account_setting');
Route::post('/store_supplier_account_setting', 'Purchase\SupplierController@store_supplier_account_setting');
Route::post('/get_supplier_account/{id}', 'Purchase\SupplierController@get_supplier_account');
