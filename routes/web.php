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

Route::post('/customer/customer-register', 'CustomerController@register');
Route::post('/customer/customer-logout', 'CustomerController@logout');
Route::post('/customer/customer-session', 'CustomerController@sessionData');
Route::post('/customer/home', 'CategoryController@index');
Route::post('/customer/category/{id}', 'ProductController@index');
Route::post('/customer/product-details/{id}', 'ProductController@getProductDetails');
Route::post('/customer/featured-product', 'customer\CartController@getFeaturedProducts');
Route::post('/customer/new-product', 'customer\CartController@getNewProducts');

Route::get('/customer/add-cart/{id}/{cartQty}', 'customer\CartController@addToCart');
Route::post('/customer/all-cart', 'customer\CartController@allCart');
Route::post('/customer/delete-cart', 'customer\CartController@deleteCart');
Route::post('/customer/update-cart', 'customer\CartController@updateCart');
Route::post('/customer/confirm-order', 'OrderController@store');
Route::post('/customer/shipping-info', 'OrderController@update');
// ------------------------------------accounts-------------------------------------------------------------------------------------------------------------------------

Route::post('/tree_account', 'AccountController@tree_account');
Route::post('/account/{id}', 'AccountController@edit');
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
Route::post('/AccountExport', 'AccountController@Export');
Route::post('/AccountImport', 'AccountController@Import');

// ------------------------------------dailys-------------------------------------------------------------------------------------------------------------------------

// Route::post('/dailys', 'DailyController@index');
Route::post('/store_daily', 'DailyController@store');

################################################Supply##################################
Route::post('/supply/newsupply', 'SupplyController@index');

Route::post('/supply/delete', 'SupplyController@destroy');

// Route::post('/add_supply/{id}', 'SupplyController@store');

Route::post('/add_supply', 'SupplyController@store');

Route::post('/paysupply', 'SupplyController@payment');


Route::post('/supply/newsupplysearch', 'SupplyController@search_new');

Route::post('/listsupply', 'SupplyController@show');

Route::post('/listsupplysearch', 'SupplyController@search');

Route::post('/supply_details/{id}', 'SupplyController@details_supply');
Route::post('/invoice_supply/{id}', 'SupplyController@invoice_supply');
Route::post('/recive_supply/{id}', 'SupplyController@recive_supply');

Route::post('/Reposupply', 'SupplyController@get_data_for_report');
Route::post('/reposupply_by_supplier', 'SupplyController@reposupply_by_supplier');
Route::post('/Reposupplyreturn', 'SupplyReturnController@get_data_for_report');
Route::post('/reposupplyreturn_by_supplier', 'SupplyReturnController@reposupplyreturn_by_supplier');


Route::post('/repo_movement', 'SupplyController@repo_movement');
Route::post('/repo_stock', 'SupplyController@repo_stock');

################################################sale##################################
Route::post('/sale/newsale', 'SaleController@index');
Route::post('/listsale', 'SaleController@show');
Route::post('/listsalesearch', 'SaleController@search');
Route::post('/add_sale', 'SaleController@store');
Route::post('/paysale', 'SaleController@payment');
Route::post('/sale_details/{id}', 'SaleController@details_sale');


Route::post('/invoice_sale/{id}', 'SaleController@invoice_sale');

Route::post('/salereturn', 'SaleReturnController@create');
Route::post('/listreturn_sale/{id}', 'SaleReturnController@show');

Route::post('/returnsale_details/{id}', 'SaleReturnController@return_sale_detail');

Route::post('/invoice_return_sale/{id}', 'SaleReturnController@return_invoice');

################################################purchase##################################
Route::post('/purchase/newpurchase', 'PurchaseController@index');
Route::post('/purchase/newpurchasesearch', 'PurchaseController@search');
Route::post('/listpurchase', 'PurchaseController@show');
Route::post('/listpurchasesearch', 'PurchaseController@search');
Route::post('/add_purchase', 'PurchaseController@store');
Route::post('/paypurchase', 'purchaseController@payment');
Route::post('/purchase_details/{id}', 'PurchaseController@details_purchase');
Route::post('/purchasereturn', 'PurchaseReturnController@create');

Route::post('/listreturn_purchase/{id}', 'PurchaseReturnController@show');

Route::post('/listreturn_purchasesearch', 'PurchaseReturnController@search');

Route::post('/returnpurchase_details/{id}', 'PurchaseReturnController@return_purchase_detail');

Route::post('/invoice_purchase/{id}', 'PurchaseController@invoice_purchase');

Route::post('/invoice_return_purchase/{id}', 'PurchaseReturnController@return_invoice');





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

################################################Cashing##################################
Route::post('/cash/newcash', 'CashController@index');

Route::post('/cash/delete', 'CashController@destroy');

// Route::post('/add_cash/{id}', 'CashController@store');

Route::post('/add_cash', 'CashController@store');
Route::post('/paycash', 'CashController@payment');

Route::post('/cash/newcashsearch', 'CashController@search_new');


Route::post('/listcash', 'CashController@show');
Route::post('/cash_details/{id}', 'CashController@details_cash');
Route::post('/invoice_cash/{id}', 'CashController@invoice_cash');
Route::post('/recive_cash/{id}', 'CashController@recive_cash');


Route::post('/Repocash', 'CashController@get_data_for_report');
Route::post('/repocash_by_customer', 'CashController@repocash_by_customer');
Route::post('/Repocashreturn', 'CashController@get_data_for_report');
Route::post('/repocashreturn_by_customer', 'CashController@repocashreturn_by_customer');


##################################################################################
Route::group(['middleware' => ['guest']], function () {
    // dd('sad');

    Route::get('admin/login', function () {
        return view('auth/login');
    });

    Route::get('admin/register', function () {
        return view('auth/register');
    });

    Route::get('customer/login', function () {
        return view('auth/login');
    });

    Route::get('customer/register', function () {
        return view('auth/register');
    });
});

Auth::routes();

Route::get('/logout', 'HomeController@logout');

Route::group(['middleware' => ['auth']], function () {


    Route::group(['middleware' => ['Customer']], function () {

        Route::get('/{page}', function () {
            return view('admin/layouts/master');
        });
        Route::get('/{page}/{id}', function () {
            return view('admin/layouts/master');
        });
        Route::get('/', function () {
            return view('admin/layouts/master');
        });
    });
    Route::post('/dashboard', 'HomeController@show');
    #######################Category##############################






    #######################User##############################
    Route::post('/user', 'UserController@index');
    Route::post('/create_user', 'UserController@create');
    Route::post('/store_user', 'UserController@store');
    Route::post('/update_user/{id}', 'UserController@update');
    Route::post('/user/{id}', 'UserController@edit');
    Route::post('/delete_user/{id}', 'UserController@destroy');

    Route::post('/usersearch', 'UserController@search');
    #######################customer##############################
    Route::post('/customer', 'CustomerController@index');
    Route::post('/create_customer', 'CustomerController@create');
    Route::post('/store_customer', 'CustomerController@store');
    Route::post('/update_customer/{id}', 'CustomerController@update');
    Route::post('/customer/{id}', 'CustomerController@edit');
    Route::post('/delete_customer/{id}', 'CustomerController@destroy');

    Route::post('/customersearch', 'CustomerController@search');
    ########################Product#############################
    Route::post('/product', 'ProductController@index');
    Route::post('/create_product', 'ProductController@create');
    Route::post('/store_product', 'ProductController@store');
    Route::post('/update_product/{id}', 'ProductController@update');
    Route::get('/product/{id}', 'ProductController@edit');
    Route::post('/delete_product/{id}', 'ProductController@destroy');
    // -------------------------------------------------------


    Route::post('/tree_product', 'ProductController@tree_product');


    Route::post('/store_first_level', 'ProductController@store_first_level');

    Route::post('/product_edit_node/{id}', 'ProductController@product_edit_node');
    Route::post('/product_store_first_level', 'ProductController@product_store_first_level');
    Route::post('/product_details_node/{id}', 'ProductController@product_details_node');
    Route::post('/product_update_node/{id}', 'ProductController@product_update_node');
    Route::post('/product_rename_node/{id}', 'ProductController@product_rename_node');
    Route::post('/get_product_main/{id}', 'ProductController@get_producte_main');
    Route::post('/get_product_name/{id}', 'ProductController@get_product_name');
    Route::post('/delete_product/{id}', 'ProductController@destroy');
    //  ------------------------------------------------------------#--------------------------
    Route::post('/ProductExport', 'ProductController@Export');
    Route::post('/ProductImport', 'ProductController@Import');

    Route::post('/productsearch', 'ProductController@search');
    ######################################################################
    // Route::post('/unit', 'UnitController@index');
    // Route::post('/create_unit', 'UnitController@create');
    // Route::post('/store_unit', 'UnitController@store');
    // Route::post('/update_unit/{id}', 'UnitController@upate');
    // Route::post('/unit/{id}', 'UnitrController@edit');
    // Route::post('/delete_unit/{id}', 'UnitController@destroy');

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

    Route::post('/returnsupply_details/{id}', 'SupplyReturnController@return_supply_detail');
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

    Route::post('/returncash_details/{id}', 'CashReturnController@return_cash_detail');
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

    #########################Country############################





    #########################TypeProduct############################

    ##########################Size###########################
    // Route::post('/size', 'SizeController@index');
    // Route::post('/store_size', 'SizeController@store');
    // Route::post('/update_size/{id}', 'SizeController@update');
    // Route::post('/size/{id}', 'SizeController@edit');
    // Route::post('/delete_size/{id}', 'SizeController@destroy');
    ##########################Order#################################
    // Route::post('/order', 'OrderController@index');
    // Route::post('/order-details/{id}', 'OrderDetailController@index');
    // Route::post('/order-invoice/{id}', 'OrderDetailController@orderinvoice');
    // Route::post('/product-order/{id}', 'OrderDetailController@orderproduct');
    // Route::post('/customer-order/{id}', 'OrderDetailController@ordercustomer');
    // Route::post('/payment-details/{id}', 'PaymentController@index');
    // Route::post('/user_name', 'HomeController@show');
    ##########################OrderRefund#################################
    // Route::post('/order/get_refunded', 'RefundOrderController@index');
    // Route::post('/order/refund', 'RefundOrderController@create');
    // Route::post('/product-reorder/{id}', 'RefundOrderController@product_reorder');
    // Route::post('/customer-reorder/{id}', 'RefundOrderController@customer_reorder');


    ################################################purchase##################################
    // Route::post('/purchase/newpurchase', 'PurchaseController@index');
    // Route::post('/add_purchase/{id}', 'PurchaseController@store');
    // Route::post('/paypurchase', 'purchaseController@payment');
    // Route::post('/purchase_pendding', 'PurchaseController@show');
    // Route::post('/product-purchase/{id}', 'PurchaseDetailController@purchaseproduct');
    // Route::post('/supplier-purchase/{id}', 'PurchaseDetailController@purchasesupplier');
    // Route::post('/purchase-details/{id}', 'PurchaseDetailController@index');
    ##########################PurchaseRefund#################################
    // Route::post('/purchase/get_refunded', 'RefundPurchaseController@index');
    // Route::post('/purchase/refund', 'RefundPurchaseController@create');
    // Route::post('/product-repurchase/{id}', 'RefundPurchaseController@product_repurchase');
    // Route::post('/supplier-repurchase/{id}', 'RefundPurchaseController@supplier_repurchase');
    #########################staff############################
    Route::post('/staff', 'StaffController@index');
    Route::post('store_staff', 'StaffController@store');
    Route::post('/update_staff/{id}', 'StaffController@update');
    Route::post('/staff/{id}', 'StaffController@edit');
    Route::post('/delete_staff/{id}', 'StaffController@destroy');

    Route::post('/staffsearch', 'StaffController@search');
    // Route::post('/staffExport', 'StaffController@Export');
    // Route::post('/staffImport', 'StaffController@Import');

    #########################staff############################
    // ---------------------------------attendance-----------------------------------------------
    Route::post('/store_attendance', 'AttendanceController@store');
    Route::post('/attendance', 'AttendanceController@index');
    //  --------------------------------------------------------------------------
    Route::post('/salary', 'SalaryController@index');
    Route::post('/store_salary', 'SalaryController@store');
    Route::post('/update_salary/{id}', 'SalaryController@update');
    Route::post('/salary/{id}', 'SalaryController@edit');
    Route::post('/delete_salary/{id}', 'SalaryController@destroy');

    Route::post('/salarysearch', 'SalaryController@search');

    Route::post('/salary_details', 'SalaryController@salary_details');

    //  ----------------------------branch----------------------------------------

    Route::post('/branch', 'BranchController@index');
    Route::post('/create_branch', 'BranchController@create');
    Route::post('/store_branch', 'BranchController@store');
    Route::post('/update_branch/{id}', 'BranchController@update');
    Route::post('/branch/{id}', 'BranchController@edit');
    Route::post('/delete_branch/{id}', 'BranchController@destroy');
    Route::post('/branchsearch', 'BranchController@search');

    //  --------------------------------department------------------------------------
    Route::post('/department', 'DepartmentController@index');
    Route::post('/create_department', 'DepartmentController@create');
    Route::post('/store_department', 'DepartmentController@store');
    Route::post('/update_department/{id}', 'DepartmentController@update');
    Route::post('/department/{id}', 'DepartmentController@edit');
    Route::post('/delete_department/{id}', 'DepartmentController@destroy');
    Route::post('/departmentsearch', 'DepartmentController@search');

    //  --------------------------------------job------------------------------

    Route::post('/job', 'JobController@index');
    Route::post('/create_job', 'JobController@create');
    Route::post('/store_job', 'JobController@store');
    Route::post('/update_job/{id}', 'JobController@update');
    Route::post('/job/{id}', 'JobController@edit');
    Route::post('/delete_job/{id}', 'JobController@destroy');
    Route::post('/jobsearch', 'JobController@search');

    //  ------------------------------staff_type--------------------------------------

    Route::post('/staff_type', 'StaffTypeController@index');
    Route::post('/create_staff_type', 'StaffTypeController@create');
    Route::post('/store_staff_type', 'StaffTypeController@store');
    Route::post('/update_staff_type/{id}', 'StaffTypeController@update');
    Route::post('/staff_type/{id}', 'StaffTypeController@edit');
    Route::post('/delete_staff_type/{id}', 'StaffTypeController@destroy');
    Route::post('/staff_typesearch', 'StaffTypeController@search');

    //  --------------------------------qualification------------------------------------

    Route::post('/qualification', 'QualificationController@index');
    Route::post('/create_qualification', 'QualificationController@create');
    Route::post('/store_qualification', 'QualificationController@store');
    Route::post('/update_qualification/{id}', 'QualificationController@update');
    Route::post('/qualification/{id}', 'QualificationController@edit');
    Route::post('/delete_qualification/{id}', 'QualificationController@destroy');
    Route::post('/qualificationsearch', 'QualificationController@search');
    //  ---------------------------------------nationality-----------------------------
    Route::post('/nationality', 'NationalityController@index');
    Route::post('/create_nationality', 'NationalityController@create');
    Route::post('/store_nationality', 'NationalityController@store');
    Route::post('/update_nationality/{id}', 'NationalityController@update');
    Route::post('/nationality/{id}', 'NationalityController@edit');
    Route::post('/delete_nationality/{id}', 'NationalityController@destroy');
    Route::post('/nationalitysearch', 'NationalityController@search');
    //  ---------------------------------------religion-----------------------------

    Route::post('/religion', 'StaffReligionController@index');
    Route::post('/create_religion', 'StaffReligionController@create');
    Route::post('/store_religionh', 'StaffReligionController@store');
    Route::post('/update_religion/{id}', 'StaffReligionController@update');
    Route::post('/religion/{id}', 'StaffReligionController@edit');
    Route::post('/delete_religion/{id}', 'StaffReligionController@destroy');
    Route::post('/religionsearch', 'StaffReligionController@search');
    //  ---------------------------------------absence_type-----------------------------
    Route::post('/absence_type', 'AbsenceController@index');
    Route::post('/create_absence_type', 'AbsenceController@create');
    Route::post('/storeabsence_type', 'AbsenceController@store');
    Route::post('/update_absence_type/{id}', 'AbsenceController@update');
    Route::post('/absence_type/{id}', 'AbsenceController@edit');
    Route::post('/delete_absence_type/{id}', 'AbsenceController@destroy');
    Route::post('/absence_typesearch', 'AbsenceController@search');
    // --------------------------------------------------------------------------------
    //  ---------------------------------------allowance_type-----------------------------
    Route::post('/allowance_type', 'AllowanceController@index');
    Route::post('/create_allowance_type', 'AllowanceController@create');
    Route::post('/storeallowance_type', 'AllowanceController@store');
    Route::post('/update_allowance_type/{id}', 'AllowanceController@update');
    Route::post('/allowance_type/{id}', 'AllowanceController@edit');
    Route::post('/delete_allowance_type/{id}', 'AllowanceController@destroy');
    Route::post('/allowance_typesearch', 'AllowanceController@search');
    Route::post('/store_allowance', 'AllowanceController@store');
    //  ---------------------------------------allowance_type-----------------------------
    Route::post('/extra_type', 'ExtraController@index');
    Route::post('/create_extra_type', 'ExtraController@create');
    Route::post('/storeextra_type', 'ExtraController@store');
    Route::post('/update_extra_type/{id}', 'ExtraController@update');
    Route::post('/extra_type/{id}', 'ExtraController@edit');
    Route::post('/delete_extra_type/{id}', 'ExtraController@destroy');
    Route::post('/extra_typesearch', 'ExtraController@search');

    //  ---------------------------------------delay_type-----------------------------
    Route::post('/delay_type', 'DelayController@index');
    Route::post('/create_delay_type', 'DelayController@create');
    Route::post('/storedelay_type', 'DelayController@store');
    Route::post('/update_delay_type/{id}', 'DelayController@update');
    Route::post('/delay_type/{id}', 'DelayController@edit');
    Route::post('/delete_delay_type/{id}', 'DelayController@destroy');
    Route::post('/delay_typesearch', 'DelayController@search');




    // --------------------------------------------------------Absence---------------------------------------------------------------------
    Route::post('/absence', 'AbsenceController@index');
    Route::post('/store_absence', 'AbsenceController@store');

    // --------------------------------------------------------Delay---------------------------------------------------------------------
    Route::post('/delay', 'DelayController@index');
    Route::post('/store_delay', 'DelayController@store');
    // --------------------------------------------------------Extra---------------------------------------------------------------------
    Route::post('/extra', 'ExtraController@index');
    Route::post('/store_extra', 'ExtraController@store');
    // --------------------------------------------------------Discount---------------------------------------------------------------------
    Route::post('/discount', 'DiscountController@index');
    Route::post('/store_discount', 'DiscountController@store');

    // --------------------------------------------------------Vacation---------------------------------------------------------------------
    Route::post('/vacation', 'VacationController@index');
    Route::post('/store_leave', 'VacationController@store');
    Route::post('/select_staff', 'VacationController@select_staff');

    // --------------------------------------------------------loan---------------------------------------------------------------------
    Route::post('/loan', 'LoanController@index');
    Route::post('/store_loan', 'LoanController@store');
    // --------------------------------------------------------loan---------------------------------------------------------------------
    Route::post('/advance', 'AdvanceController@index');
    Route::post('/store_advance', 'AdvanceController@store');
});
