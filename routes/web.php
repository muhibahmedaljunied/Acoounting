<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/test-event', 'AbsenceController@test');
Route::get('/images/{image}', 'AbsenceController@test');

Route::get('/test-event', 'AbsenceSanctionController@index');

//-----------------------customer------------------------------
// Route::post('/dailys', 'DailyController@index');
Route::post('/store_daily', 'DailyController@store');


Auth::routes();
Route::get('/logout', 'HomeController@logout');
Route::group(['middleware' => ['auth']], function () {


    Route::get('/logout', 'HomeController@logout');

    Route::get('/{page}', function () {
        return view('admin/layouts/master');
    });
    Route::get('/{page}/{id}', function () {
        return view('admin/layouts/master');
    });
    Route::get('/', function () {
        return view('admin/layouts/master');
    });
    Route::post('/dashboard', 'HomeController@show');


    require __DIR__ . '\user.php';
    require __DIR__ . '\account.php';
    require __DIR__ . '\warehouse.php';
    require __DIR__ . '\hr.php';
    require __DIR__ . '\sale.php';
    require __DIR__ . '\purchase.php';
});
