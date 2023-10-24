<?php

use Illuminate\Support\Facades\Route;
//-----------------------User-
Route::post('/user', 'UserController@index');
Route::post('/create_user', 'UserController@create');
Route::post('/store_user', 'UserController@store');
Route::post('/update_user/{id}', 'UserController@update');
Route::post('/user/{id}', 'UserController@edit');
Route::post('/delete_user/{id}', 'UserController@destroy');
Route::post('/usersearch', 'UserController@search');
