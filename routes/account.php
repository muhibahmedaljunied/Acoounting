<?php

use Illuminate\Support\Facades\Route;
#######################account##############################

Route::post('/tree_account', 'AccountController@tree_account');
Route::post('/account/{id}', 'AccountController@edit');
Route::post('/delete_account/{id}', 'AccountController@destroy');
Route::post('/store_account', 'AccountController@store');
Route::post('/account_list/{id}', 'AccountController@AccountStatement');
Route::post('/account_details_node/{id}', 'AccountController@account_details_node');
Route::post('/account_update_node/{id}', 'AccountController@account_update_node');
Route::post('/account_edit_node/{id}', 'AccountController@account_edit_node');
// ------------------------------------------
Route::post('/account_store_first_level', 'AccountController@account_store_first_level');


Route::post('/account_rename_node/{id}', 'AccountController@account_rename_node');

// ---------------------------------------------
Route::post('/get_account_main/{id}', 'AccountController@get_account_main');
Route::post('/get_account_name/{id}', 'AccountController@get_account_name');
Route::post('/auditBalance', 'AccountController@auditBalance');

// --------------------------------banks------------------------------------------
Route::post('/banks', 'BankController@show');
// --------------------------------Currencies------------------------------------------
Route::post('/currencies', 'CurrencyController@show');
// --------------------------------treasuries------------------------------------------
Route::post('/treasuries', 'TreasuryController@show');
// --------------------------------type_expence------------------------------------------
Route::post('/type_expence', 'TypeExpenceController@show');
// --------------------------------type_income------------------------------------------
Route::post('/type_income', 'TypeIncomeController@show');
// --------------------------------expence_type------------------------------------------
Route::post('/expence_type', 'ExpenceTypeController@show');



################################################expence##################################
Route::post('/expence/newexpence', 'ExpenceController@index');

Route::post('/expence/delete', 'ExpenceController@destroy');

Route::post('/store_expence', 'ExpenceController@store');

Route::post('/payexpence', 'ExpenceController@payment');

Route::post('/expences', 'ExpenceController@show');

Route::post('/expence/newexpencesearch', 'ExpenceController@search_new');

Route::post('/listexpence', 'ExpenceController@show');

Route::post('/listexpencesearch', 'ExpenceController@search');

Route::post('/expence_details/{id}', 'ExpenceController@details_supply');
Route::post('/invoice_expence/{id}', 'ExpenceController@invoice_supply');
Route::post('/recive_expence/{id}', 'ExpenceController@recive_supply');