<?php

use Illuminate\Support\Facades\Route;

Route::post('/product', 'ProductController@index');
Route::post('/create_product', 'ProductController@create');
Route::post('/store_product', 'ProductController@store');
Route::post('/update_product/{id}', 'ProductController@update');
Route::get('/product/{id}', 'ProductController@edit');
Route::post('/delete_product/{id}', 'ProductController@destroy');
// -------------------------------------------------------

// Route::post('/store_first_level', 'ProductController@store_first_level');
Route::post('/tree_product', 'ProductController@tree_product');
Route::post('/product_edit_node/{id}', 'ProductController@product_edit_node');
Route::post('/product_store_first_level', 'ProductController@product_store_first_level');
Route::post('/product_details_node/{id}', 'ProductController@product_details_node');
Route::post('/product_update_node/{id}', 'ProductController@product_update_node');
Route::post('/product_rename_node/{id}', 'ProductController@product_rename_node');
Route::post('/get_product_main/{id}', 'ProductController@get_producte_main');
Route::post('/get_product_name/{id}', 'ProductController@get_product_name');
Route::post('/delete_product/{id}', 'ProductController@destroy');
Route::post('/productsearch', 'ProductController@search');
######################################################################

Route::post('/get_unit/{id}', 'UnitController@show');
Route::post('/unit', 'UnitController@index');
Route::post('/create_unit', 'UnitController@create');
Route::post('/store_unit', 'UnitController@store');
Route::post('/update_unit/{id}', 'UnitController@upate');
Route::post('/unit/{id}', 'UnitrController@edit');
Route::post('/delete_unit/{id}', 'UnitController@destroy');

########################################################################
Route::post('/supply', 'SupplyController@index');

// Route::post('/supplyreturn/check_qty/{id}', 'SupplyReturnController@check_qty');

Route::post('/create_supply', 'SupplyController@create');
Route::post('/store_supply', 'SupplyController@store');
Route::post('/stock', 'StockController@index');

Route::post('/stocksearch', 'StockController@search');

Route::post('/supply_product/{id}', 'SupplyController@product_for_category');


Route::post('/data_for_supply', 'SupplyController@data_for_supply');
Route::post('/data_for_supply_return', 'SupplyReturnController@data_for_supply_return');

Route::post('/supplyreturn', 'SupplyReturnController@create');
// Route::post('/listreturn_supply', 'SupplyReturnController@show');
Route::post('/listreturn_supply/{id}', 'SupplyReturnController@show');

Route::post('/listreturn_supplysearch', 'SupplyReturnController@search');

Route::post('/returnsupply_details/{id}', 'SupplyReturnController@return_detail');
// Route::post('/return_details_s/{id}', 'SupplyReturnController@return_detail');

Route::post('/invoice_return_supply/{id}', 'SupplyReturnController@return_invoice');
Route::post('/recive_return_supply/{id}', 'SupplyReturnController@return_recive');



##########################Supplier#######################################
Route::post('/cash', 'CashController@index');
Route::post('/create_cash', 'CashController@create');
Route::post('/store_cash', 'CashController@store');
Route::post('/cash/check_qty/{id}', 'CashController@check_qty');
Route::post('/cash_product/{id}', 'CashController@product_for_category');


Route::post('/data_for_cash', 'CashController@data_for_cash');
Route::post('/data_for_cash_return', 'CashReturnController@data_for_cash_return');

Route::post('/cashreturn', 'CashReturnController@create');
Route::post('/cashreturn/check_qty/{id}', 'CashReturnController@check_qty');


Route::post('/listreturn_cash/{id}', 'CashReturnController@show');

Route::post('/returncash_details/{id}', 'CashReturnController@return_detail');
// Route::post('/return_details_c/{id}', 'CashReturnController@return_detail');

Route::post('/invoice_return_cash/{id}', 'CashReturnController@return_invoice');
Route::post('/recive_return_cash/{id}', 'CashReturnController@return_recive');
##########################Supplier#######################################
Route::post('/supplier', 'SupplierController@index');
Route::post('/store_supplier', 'SupplierController@store');
Route::post('/update_supplier/{id}', 'SupplierController@update');
Route::post('/supplier/{id}', 'SupplierController@edit');
Route::post('/delete_supplier/{id}', 'SupplierController@destroy');

Route::post('/suppliersearch', 'SupplierController@search');
Route::post('/supplier/supplier_account_list/{id}', 'SupplierController@show');
Route::post('/SupplierExport', 'SupplierController@Export');
Route::post('/SupplierImport', 'SupplierController@Import');

####################################################################

Route::post('/tree_store', 'StoreController@tree_store');

Route::post('/store_store_first_level', 'StoreController@store_store_first_level');

Route::post('/store_details_node/{id}', 'StoreController@store_details_node');

Route::post('/store_update_node/{id}', 'StoreController@store_update_node');
Route::post('/store_rename_node/{id}', 'StoreController@store_rename_node');
Route::post('/store_edit_node/{id}', 'StoreController@store_edit_node');


Route::post('/get_store_main/{id}', 'StoreController@get_store_main');

Route::post('/get_store_name/{id}', 'StoreController@get_store_name');

Route::post('/store', 'StoreController@index');
Route::post('/store_store', 'StoreController@store');
Route::post('/update_store/{id}', 'StoreController@update');
Route::post('/store/{id}', 'StoreController@edit');
Route::post('/delete_store/{id}', 'StoreController@destroy');

Route::post('/storesearch', 'StoreController@search');

Route::post('/StoreExport', 'StoreController@Export');
Route::post('/StoreImport', 'StoreController@Import');

####################################################################
Route::post('/status', 'StatusController@index');
Route::post('/store_status', 'StatusController@store');
Route::post('/update_status/{id}', 'StatusController@update');
Route::post('/status/{id}', 'StatusController@edit');
Route::post('/delete_status/{id}', 'StatusController@destroy');

Route::post('/statussearch', 'StatusController@search');

Route::post('/StatusExport', 'StatusController@Export');
Route::post('/StatusImport', 'StatusController@Import');
// ----------------------------------------------sale----------------------
Route::post('/sale/newsale', 'SaleController@index');
Route::post('/sale/newsale/{id}', 'SaleController@index');
Route::post('/listsale', 'SaleController@show');
Route::post('/listsalesearch', 'SaleController@search');
Route::post('/add_Sale', 'SaleController@store');
Route::post('/paySale', 'SaleController@payment');
Route::post('/sale_details/{id}', 'SaleController@details');

Route::post('/Sale/delete', 'SaleController@destroy');
Route::post('/Sale/delete/{id}', 'SaleController@destroy');

Route::post('/invoice_sale/{id}', 'SaleController@invoice_sale');

Route::post('/salereturn', 'SaleReturnController@create');
Route::post('/listreturn_sale/{id}', 'SaleReturnController@show');

Route::post('/returnsale_details/{id}', 'SaleReturnController@return_detail');

Route::post('/invoice_return_sale/{id}', 'SaleReturnController@return_invoice');

################################################purchase##################################
Route::post('/purchase/newpurchase', 'PurchaseController@index');
Route::post('/Purchase/delete', 'PurchaseController@destroy');
Route::post('/Purchase/delete/{id}', 'PurchaseController@destroy');
Route::post('/purchase/newpurchasesearch', 'PurchaseController@search');
Route::post('/listpurchase', 'PurchaseController@show');
Route::post('/listpurchasesearch', 'PurchaseController@search');
Route::post('/add_Purchase', 'PurchaseController@store');
Route::post('/payPurchase', 'purchaseController@payment');
Route::post('/purchase_details/{id}', 'PurchaseController@details');
Route::post('/purchasereturn', 'PurchaseReturnController@create');
Route::post('/listreturn_purchase/{id}', 'PurchaseReturnController@show');
Route::post('/listreturn_purchasesearch', 'PurchaseReturnController@search');
Route::post('/returnpurchase_details/{id}', 'PurchaseReturnController@return_detail');
Route::post('/invoice_purchase/{id}', 'PurchaseController@invoice_purchase');
Route::post('/invoice_return_purchase/{id}', 'PurchaseReturnController@return_invoice');
Route::post('/payment_bond/{id}', 'PurchaseController@payment_bond');

Route::post('/payment_bond', 'PayableNoteController@index');
Route::post('/payment_bond_store/{id}', 'PayableNoteController@store');
// ------------------------------------Transfer------------------------------------------------------------------------------------------------------------------------------------
Route::post('/transfer', 'TransferController@index');
Route::post('/transfer_before', 'TransferController@show');
Route::post('/create_transfer', 'TransferController@create');
Route::post('/store_transfer', 'TransferController@store');
Route::post('/paytransfer', 'TransferController@payment');
Route::post('/update_transfer/{id}', 'TransferController@update');
Route::post('/transfer/{id}', 'TransferController@edit');
Route::post('/delete_transfer/{id}', 'TransferController@destroy');

Route::post('/data_for_transfer', 'TransferController@data_for_transfer');
Route::post('/get_product', 'TransferController@get_product');


Route::post('/transfersearch', 'TransferController@search');
Route::post('/listtransfer', 'TransferController@index');
Route::post('/details_transfer/{id}', 'TransferController@details_transfer');
################################################Supply##################################
Route::post('/supply/newsupply', 'SupplyController@index');

Route::post('/Supply/delete', 'SupplyController@destroy');
Route::post('/Supply/delete/{id}', 'SupplyController@destroy');

// Route::post('/add_Supply/{id}', 'SupplyController@store');

Route::post('/add_Supply', 'SupplyController@store');

Route::post('/paysupply', 'SupplyController@payment');


Route::post('/supply/newsupplysearch', 'SupplyController@search_new');

Route::post('/listsupply', 'SupplyController@show');

Route::post('/listsupplysearch', 'SupplyController@search');

Route::post('/supply_details/{id}', 'SupplyController@details');
Route::post('/invoice_supply/{id}', 'SupplyController@invoice_supply');
Route::post('/recive_supply/{id}', 'SupplyController@recive_supply');

Route::post('/Reposupply', 'SupplyController@get_data_for_report');
Route::post('/reposupply_by_supplier', 'SupplyController@reposupply_by_supplier');
Route::post('/Reposupplyreturn', 'SupplyReturnController@get_data_for_report');
Route::post('/reposupplyreturn_by_supplier', 'SupplyReturnController@reposupplyreturn_by_supplier');
Route::post('/repo_movement', 'SupplyController@repo_movement');
Route::post('/repo_stock', 'SupplyController@repo_stock');
// -------------------------------------OpeningInventury----------------------------------------------------------
Route::post('/add_Opening', 'InventuryController@store');
Route::post('/opening/newopening', 'InventuryController@index');

