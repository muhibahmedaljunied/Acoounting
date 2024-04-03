<?php

use App\Http\Controllers\Warehouse\ProductController;
use App\Http\Controllers\Warehouse\StoreController;
use Illuminate\Support\Facades\Route;

//-------------------------------product--------------------------------------------------------------------------------------


Route::post('import_product', [ProductController::class, 'import']);
Route::post('export_product', [ProductController::class, 'export']);
Route::post('/product', 'Warehouse\ProductController@index');
Route::post('/create_product', 'Warehouse\ProductController@create');
Route::post('/store_product', 'Warehouse\ProductController@store');
Route::post('/update_product/{id}', 'Warehouse\ProductController@update');
Route::get('/product/{id}', 'Warehouse\ProductController@edit');
Route::post('/delete_product/{id}', 'Warehouse\ProductController@destroy');
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
//-------------------------------------Unit------------------------------------------------------------------------------

Route::post('/get_unit/{id}', 'Warehouse\UnitController@show');
Route::post('/unit', 'Warehouse\UnitController@index');
Route::post('/create_unit', 'Warehouse\UnitController@create');
Route::post('/store_unit', 'Warehouse\UnitController@store');
Route::post('/update_unit/{id}', 'Warehouse\UnitController@upate');
Route::post('/unit/{id}', 'Warehouse\UnitController@edit');
Route::post('/delete_unit/{id}', 'Warehouse\UnitController@destroy');
Route::post('/store_store_account_setting', 'Warehouse\StoreController@store_store_account_setting');
Route::post('/get_store_account_setting', 'Warehouse\StoreController@get_store_account_setting');
Route::post('/stock', 'Warehouse\StockController@index');

Route::post('/stocksearch', 'Warehouse\StockController@search');


//-------------------------------store--------------------------------------------------------------------------------------

Route::post('import_store', [StoreController::class, 'import']);
Route::post('export_store', [StoreController::class, 'export']);

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
Route::post('/repo_stock', 'Warehouse\SupplyController@repo_stock');
// -------------------------------------OpeningInventury----------------------------------------------------------
Route::post('/add_Opening', 'Warehouse\InventuryController@store');
Route::post('/opening/newopening', 'Warehouse\InventuryController@index');
// -------------------------------------------
Route::post('/Warehouse/pricing', 'Warehouse\InventuryController@pricing');
