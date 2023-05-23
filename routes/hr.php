<?php
use Illuminate\Support\Facades\Route;


Route::post('/tree_structure', 'AdministrativeStructureController@tree_structure');
Route::post('/structure_details_node/{id}', 'AdministrativeStructureController@structure_details_node');
Route::post('/tree_job', 'AdministrativeStructureController@tree_structure');
Route::post('/store_structure', 'AdministrativeStructureController@store');
Route::post('/delete_structure/{id}', 'AdministrativeStructureController@destroy');
// --------------------------------staff---------------------------------------------------------
Route::post('/staff', 'StaffController@index');
Route::post('/staff/{id}', 'StaffController@select_staff');
Route::post('store_staff', 'StaffController@store');
Route::post('/update_staff/{id}', 'StaffController@update');
Route::post('/staff/{id}', 'StaffController@edit');
Route::post('/delete_staff/{id}', 'StaffController@destroy');
Route::post('/staff/select_staff', 'StaffController@select_staff');

Route::post('/staffsearch', 'StaffController@search');
Route::post('/staff/get_job/{id}', 'StaffController@get_job');

#########################staff############################

// -----------------------------------period-----------------
Route::post('/period', 'PeriodController@index');
Route::post('/store_period', 'PeriodController@store');

// -----------------------------------work_type-----------------
Route::post('/work_type', 'WorkTypeController@index');
Route::post('/store_work_type', 'WorkTypeController@store');
// -----------------------------------work_system-----------------
Route::post('/work_system', 'WorkSystemController@index');
Route::post('/store_work_system', 'WorkSystemController@store');
// ---------------------------------attendance-----------------------------------------------
Route::post('/attend', 'AttendanceController@show');
Route::post('/store_attendance', 'AttendanceController@store');
Route::post('/attendance', 'AttendanceController@index');
Route::post('/attendance_report', 'AttendanceController@report');
Route::post('/attendance_report/search', 'AttendanceController@search');
Route::post('/attendance/get_period/{id}', 'AttendanceController@get_period');
Route::post('/attendance/get_staff/{id}', 'AttendanceController@get_staff');
Route::post('/attendance/select_staff', 'AttendanceController@select_staff');
//  --------------------------------------------------------------------------
Route::post('/salary', 'SalaryController@index');
Route::post('/store_salary', 'SalaryController@store');
Route::post('/update_salary/{id}', 'SalaryController@update');
Route::post('/salary/{id}', 'SalaryController@edit');
Route::post('/delete_salary/{id}', 'SalaryController@destroy');

Route::post('/salarysearch', 'SalaryController@search');

Route::post('/salary_details', 'SalaryController@salary');
Route::post('/salary_details/{id}', 'SalaryController@salary_details');
Route::post('/salary', 'SalaryController@salary');
Route::post('/salary/select_staff', 'SalaryController@select_staff');
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
Route::post('/store_religion', 'StaffReligionController@store');
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
Route::post('/allowance', 'AllowanceController@index');
Route::post('/allowance_type', 'AllowanceTypeController@index');
Route::post('/create_allowance_type', 'AllowanceController@create');
Route::post('/store_allowance_type', 'AllowanceTypeController@store');
Route::post('/update_allowance_type/{id}', 'AllowanceController@update');
Route::post('/allowance_type/{id}', 'AllowanceController@edit');
Route::post('/delete_allowance_type/{id}', 'AllowanceController@destroy');
Route::post('/allowance_typesearch', 'AllowanceController@search');
Route::post('/store_allowance', 'AllowanceController@store');
// --------------------------------------------------------------------official_holiday--------------------
Route::post('/official_holiday', 'OfficialHolidayController@index');
Route::post('/create_official_holiday', 'OfficialHolidayController@create');

Route::post('/update_official_holiday/{id}', 'OfficialHolidayController@update');
Route::post('/official_holiday/{id}', 'OfficialHolidayController@edit');
Route::post('/delete_official_holiday/{id}', 'OfficialHolidayController@destroy');
Route::post('/official_holidaysearch', 'OfficialHolidayController@search');
//  ---------------------------------------allowance_type-----------------------------
Route::post('/extra_type', 'ExtraController@index');
Route::post('/extra_part', 'ExtraPartController@index');
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

Route::post('/delay_sanction', 'DelaySanctionController@index');
Route::post('/store_delay_sanction', 'DelaySanctionController@store');




// --------------------------------------------------------Absence---------------------------------------------------------------------
Route::post('/absence', 'AbsenceController@index');
Route::post('/store_absence', 'AbsenceController@store');
Route::post('/absence_sanction', 'AbsenceSanctionController@index');
Route::post('/store_absence_sanction', 'AbsenceSanctionController@store');

// --------------------------------------------------------Delay---------------------------------------------------------------------
Route::post('/delay', 'DelayController@index');
Route::post('/store_delay', 'DelayController@store');
// --------------------------------------------------------Extra---------------------------------------------------------------------
Route::post('/extra', 'ExtraController@index');
Route::post('/store_extra', 'ExtraController@store');
Route::post('/extra/select_staff', 'ExtraController@select_staff');
Route::post('/extra_sanction', 'ExtraSanctionController@index');
Route::post('/store_extra_sanction', 'ExtraSanctionController@store');
// --------------------------------------------------------Discount---------------------------------------------------------------------
Route::post('/discount', 'DiscountController@index');
Route::post('/store_discount', 'DiscountController@store');
Route::post('/discount/select_staff', 'DiscountController@select_staff');
// --------------------------------------------------------vacation_type---------------------------------------------------------------------

Route::post('/vacation_type', 'VacationTypeController@index');
Route::post('/store_vacation_type', 'VacationTypeController@store');
// --------------------------------------------------------Vacation---------------------------------------------------------------------
Route::post('/vacation', 'VacationController@index');
Route::post('/store_leave', 'VacationController@store');
Route::post('/vacation/select_staff', 'VacationController@select_staff');
Route::post('/leave_sanction', 'LeaveSanctionController@index');
Route::post('/store_leave_sanction', 'LeaveSanctionController@store');

// --------------------------------------------------------loan---------------------------------------------------------------------
Route::post('/loan', 'LoanController@index');
Route::post('/store_loan', 'LoanController@store');
// --------------------------------------------------------loan---------------------------------------------------------------------
Route::post('/advance', 'AdvanceController@index');
Route::post('/store_advance', 'AdvanceController@store');
Route::post('/advance/select_staff', 'AdvanceController@select_staff');


