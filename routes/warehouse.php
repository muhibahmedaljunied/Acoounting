<?php

use Illuminate\Support\Facades\Route;

Route::post('/product', 'Warehouse\ProductController@index');
Route::post('/create_product', 'Warehouse\ProductController@create');
Route::post('/store_product', 'Warehouse\ProductController@store');
Route::post('/update_product/{id}', 'Warehouse\ProductController@update');
Route::get('/product/{id}', 'Warehouse\ProductController@edit');
Route::post('/delete_product/{id}', 'Warehouse\ProductController@destroy');
// -------------------------------------------------------

// Route::post('/store_first_level', 'ProductController@store_first_level');
Route::post('/tree_product', 'Warehouse\ProductController@tree_product');
Route::post('/product_edit_node/{id}', 'Warehouse\ProductController@product_edit_node');
Route::post('/product_store_first_level', 'Warehouse\ProductController@product_store_first_level');
Route::post('/product_details_node/{id}', 'Warehouse\ProductController@product_details_node');
Route::post('/product_update_node/{id}', 'Warehouse\ProductController@product_update_node');
Route::post('/product_rename_node/{id}', 'Warehouse\ProductController@product_rename_node');
Route::post('/get_product_main/{id}', 'Warehouse\ProductController@get_producte_main');
Route::post('/get_product_name/{id}', 'Warehouse\ProductController@get_product_name');
Route::post('/delete_product/{id}', 'Warehouse\ProductController@destroy');
Route::post('/productsearch', 'Warehouse\ProductController@search');
//----------------------------------------------------------------------

Route::post('/get_unit/{id}', 'Warehouse\UnitController@show');
Route::post('/unit', 'Warehouse\UnitController@index');
Route::post('/create_unit', 'Warehouse\UnitController@create');
Route::post('/store_unit', 'Warehouse\UnitController@store');
Route::post('/update_unit/{id}', 'Warehouse\UnitController@upate');
Route::post('/unit/{id}', 'Warehouse\UnitController@edit');
Route::post('/delete_unit/{id}', 'Warehouse\UnitController@destroy');

//------------------------------------------------------------------------
Route::post('/supply', 'Warehouse\SupplyController@index');

// Route::post('/supplyreturn/check_qty/{id}', 'SupplyReturnController@check_qty');

Route::post('/create_supply', 'Warehouse\SupplyController@create');
Route::post('/store_supply', 'Warehouse\SupplyController@store');
Route::post('/stock', 'Warehouse\StockController@index');

Route::post('/stocksearch', 'Warehouse\StockController@search');

Route::post('/supply_product/{id}', 'Warehouse\SupplyController@product_for_category');


Route::post('/data_for_supply', 'Warehouse\SupplyController@data_for_supply');
Route::post('/data_for_supply_return', 'Warehouse\SupplyReturnController@data_for_supply_return');

Route::post('/supplyreturn', 'Warehouse\SupplyReturnController@create');
// Route::post('/listreturn_supply', 'SupplyReturnController@show');
Route::post('/listreturn_supply/{id}', 'Warehouse\SupplyReturnController@show');

Route::post('/listreturn_supplysearch', 'Warehouse\SupplyReturnController@search');

Route::post('/returnsupply_details/{id}', 'Warehouse\SupplyReturnController@return_detail');
// Route::post('/return_details_s/{id}', 'SupplyReturnController@return_detail');

Route::post('/invoice_return_supply/{id}', 'Warehouse\SupplyReturnController@return_invoice');
Route::post('/recive_return_supply/{id}', 'Warehouse\SupplyReturnController@return_recive');

//--------------------------Supplier---------------------------------------

Route::post('/Cash/delete', 'CashController@destroy');

// Route::post('/add_Cash/{id}', 'CashController@store');

Route::post('/add_Cash', 'CashController@store');
Route::post('/paycash', 'CashController@payment');

Route::post('/cash/newcashsearch', 'CashController@search_new');


Route::post('/listcash', 'CashController@show');
Route::post('/cash_details/{id}', 'CashController@details');
Route::post('/invoice_cash/{id}', 'CashController@invoice_cash');
Route::post('/recive_cash/{id}', 'CashController@recive_cash');


Route::post('/Repocash', 'CashController@get_data_for_report');
Route::post('/repocash_by_customer', 'CashController@repocash_by_customer');
Route::post('/Repocashreturn', 'CashController@get_data_for_report');
Route::post('/repocashreturn_by_customer', 'CashController@repocashreturn_by_customer');




Route::post('/cash/newcash', 'Warehouse\CashController@index');
Route::post('/cash', 'Warehouse\CashController@index');
Route::post('/create_cash', 'Warehouse\CashController@create');
Route::post('/store_cash', 'Warehouse\CashController@store');
Route::post('/cash/check_qty/{id}', 'Warehouse\CashController@check_qty');
Route::post('/cash_product/{id}', 'Warehouse\CashController@product_for_category');


Route::post('/data_for_cash', 'Warehouse\CashController@data_for_cash');
Route::post('/data_for_cash_return', 'Warehouse\CashReturnController@data_for_cash_return');

Route::post('/cashreturn', 'Warehouse\CashReturnController@create');
Route::post('/cashreturn/check_qty/{id}', 'Warehouse\CashReturnController@check_qty');


Route::post('/listreturn_cash/{id}', 'Warehouse\CashReturnController@show');

Route::post('/returncash_details/{id}', 'Warehouse\CashReturnController@return_detail');
// Route::post('/return_details_c/{id}', 'CashReturnController@return_detail');

Route::post('/invoice_return_cash/{id}', 'Warehouse\CashReturnController@return_invoice');
Route::post('/recive_return_cash/{id}', 'Warehouse\CashReturnController@return_recive');

//--------------------------------------------------------------------

Route::post('/tree_store', 'Warehouse\StoreController@tree_store');

Route::post('/store_store_first_level', 'Warehouse\StoreController@store_store_first_level');

Route::post('/store_details_node/{id}', 'Warehouse\StoreController@store_details_node');

Route::post('/store_update_node/{id}', 'Warehouse\StoreController@store_update_node');
Route::post('/store_rename_node/{id}', 'Warehouse\StoreController@store_rename_node');
Route::post('/store_edit_node/{id}', 'Warehouse\StoreController@store_edit_node');


Route::post('/get_store_main/{id}', 'Warehouse\StoreController@get_store_main');

Route::post('/get_store_name/{id}', 'Warehouse\StoreController@get_store_name');

Route::post('/store', 'Warehouse\StoreController@index');
Route::post('/store_store', 'Warehouse\StoreController@store');
Route::post('/update_store/{id}', 'Warehouse\StoreController@update');
Route::post('/store/{id}', 'Warehouse\StoreController@edit');
Route::post('/delete_store/{id}', 'Warehouse\StoreController@destroy');

Route::post('/storesearch', 'Warehouse\StoreController@search');

Route::post('/StoreExport', 'Warehouse\StoreController@Export');
Route::post('/StoreImport', 'Warehouse\StoreController@Import');

//--------------------------------------------------------------------
Route::post('/status', 'Warehouse\StatusController@index');
Route::post('/store_status', 'Warehouse\StatusController@store');
Route::post('/update_status/{id}', 'Warehouse\StatusController@update');
Route::post('/status/{id}', 'Warehouse\StatusController@edit');
Route::post('/delete_status/{id}', 'Warehouse\StatusController@destroy');

Route::post('/statussearch', 'Warehouse\StatusController@search');

Route::post('/StatusExport', 'Warehouse\StatusController@Export');
Route::post('/StatusImport', 'Warehouse\StatusController@Import');

// ------------------------------------Transfer------------------------------------------------------------------------------------------------------------------------------------
Route::post('/transfer', 'Warehouse\TransferController@index');
Route::post('/transfer_before', 'Warehouse\TransferController@show');
Route::post('/create_transfer', 'Warehouse\TransferController@create');
Route::post('/store_transfer', 'Warehouse\TransferController@store');
Route::post('/paytransfer', 'Warehouse\TransferController@payment');
Route::post('/update_transfer/{id}', 'Warehouse\TransferController@update');
Route::post('/transfer/{id}', 'Warehouse\TransferController@edit');
Route::post('/delete_transfer/{id}', 'Warehouse\TransferController@destroy');

Route::post('/data_for_transfer', 'Warehouse\TransferController@data_for_transfer');
Route::post('/get_product', 'Warehouse\TransferController@get_product');


Route::post('/transfersearch', 'Warehouse\TransferController@search');
Route::post('/listtransfer', 'Warehouse\TransferController@index');
Route::post('/details_transfer/{id}', 'Warehouse\TransferController@details_transfer');
//------------------------------------------------Supply----------------------------------
Route::post('/supply/newsupply', 'Warehouse\SupplyController@index');

Route::post('/Supply/delete', 'Warehouse\SupplyController@destroy');
Route::post('/Supply/delete/{id}', 'Warehouse\SupplyController@destroy');

// Route::post('/add_Supply/{id}', 'SupplyController@store');

Route::post('/add_Supply', 'Warehouse\SupplyController@store');

Route::post('/paysupply', 'Warehouse\SupplyController@payment');


Route::post('/supply/newsupplysearch', 'Warehouse\SupplyController@search_new');

Route::post('/listsupply', 'Warehouse\SupplyController@show');

Route::post('/listsupplysearch', 'Warehouse\SupplyController@search');

Route::post('/supply_details/{id}', 'Warehouse\SupplyController@details');
Route::post('/invoice_supply/{id}', 'Warehouse\SupplyController@invoice_supply');
Route::post('/recive_supply/{id}', 'Warehouse\SupplyController@recive_supply');

Route::post('/Reposupply', 'Warehouse\SupplyController@get_data_for_report');
Route::post('/reposupply_by_supplier', 'Warehouse\SupplyController@reposupply_by_supplier');
Route::post('/Reposupplyreturn', 'Warehouse\SupplyReturnController@get_data_for_report');
Route::post('/reposupplyreturn_by_supplier', 'Warehouse\SupplyReturnController@reposupplyreturn_by_supplier');
Route::post('/repo_movement', 'Warehouse\SupplyController@repo_movement');
Route::post('/repo_stock', 'Warehouse\SupplyController@repo_stock');
// -------------------------------------OpeningInventury----------------------------------------------------------
Route::post('/add_Opening', 'Warehouse\InventuryController@store');
Route::post('/opening/newopening', 'Warehouse\InventuryController@index');
// -------------------------------------------

Route::post('/Warehouse/pricing', 'Warehouse\InventuryController@pricing');
