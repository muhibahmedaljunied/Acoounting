<?php

use App\Models\AbsenceSanction;
use App\Models\DelaySanction;
use App\Models\LeaveSanction;
use App\Models\ExtraSanction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Advance;
use App\Models\StaffSanction;;


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

// Typed Variadics   or variadic constructor argument
//    mock in laravel 

// class muhib
// {

//     public function index(){


//         return 'muhib';
//     }


//     public function __construct()
//     {


//         $this->id = 1;
//     }
// }

// $rr = app()->call('muhib@index');


// app('router')->post('/tree_account', 'AccountController@tree_account');
// Route::get('customer/{page}', function () {
//     return view('customer/layouts/master');
// });

// ---------------------------------------example about Collection------------------------------------------------
// Route::get('sex/sex',function(){

//     Collection::macro('toUpper', function () {
//         return $this->map(function (string $value) {
//             return Str::upper($value);
//         });
//     });

//     $collection = collect(['first', 'second']);
//     echo get_class($collection);

//     $upper = $collection->toUpper();

//     echo $upper;

// }
// );
// ---------------------------------------------------------------------------------------
Route::get('/test-events', function () {

    $re = AbsenceSanction::find(1);
    $re1 = DelaySanction::find(1);
    $re2 = LeaveSanction::find(1);
    $re3 = ExtraSanction::find(1);


    $comment = new StaffSanction();
    $comment->sanctionable()->associate($re3);
    $comment->save();


    // ---------------------------------------------------


});

// Route::get('/test-event', 'AbsenceController@test');
Route::get('/test-event', 'AbsenceSanctionController@index');


#######################customer##############################
// Route::post('/dailys', 'DailyController@index');
Route::post('/store_daily', 'DailyController@store');




// ################################################Cashing##################################




##################################################################################
// Route::group(['middleware' => ['guest']], function () {
//     // dd('sad');

//     Route::get('admin/login', function () {
//         return view('auth/login');
//     });

//     Route::get('admin/register', function () {
//         return view('auth/register');
//     });



// });

Auth::routes();

// Route::get('/logout', 'HomeController@logout');

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

    #######################User##############################
    Route::post('/user', 'UserController@index');
    Route::post('/create_user', 'UserController@create');
    Route::post('/store_user', 'UserController@store');
    Route::post('/update_user/{id}', 'UserController@update');
    Route::post('/user/{id}', 'UserController@edit');
    Route::post('/delete_user/{id}', 'UserController@destroy');
    Route::post('/usersearch', 'UserController@search');


    require __DIR__ . '\account.php';
    require __DIR__ . '\warehouse.php';
    require __DIR__ . '\hr.php';
    require __DIR__ . '\sale.php';
    require __DIR__ . '\purchase.php';

});
