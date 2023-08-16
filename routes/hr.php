<?php
use Illuminate\Support\Facades\Route;


Route::post('/tree_structure', 'Staff\AdministrativeStructureController@tree_structure');
Route::post('/structure_details_node/{id}', 'Staff\AdministrativeStructureController@structure_details_node');
Route::post('/tree_job', 'Staff\AdministrativeStructureController@tree_structure');
Route::post('/store_structure', 'Staff\AdministrativeStructureController@store');
Route::post('/delete_structure/{id}', 'Staff\AdministrativeStructureController@destroy');
// --------------------------------staff---------------------------------------------------------
Route::post('/staff', 'Staff\StaffController@index');
Route::post('/staff/{id}', 'Staff\StaffController@select_staff');
Route::post('store_staff', 'Staff\StaffController@store');
Route::post('/update_staff/{id}', 'Staff\StaffController@update');
Route::post('/staff/{id}', 'Staff\StaffController@edit');
Route::post('/delete_staff/{id}', 'Staff\StaffController@destroy');
Route::post('/staff/select_staff', 'Staff\StaffController@select_staff');

Route::post('/staffsearch', 'Staff\StaffController@search');
Route::post('/staff/get_job/{id}', 'Staff\StaffController@get_job');

#########################staff############################

// -----------------------------------period-----------------
Route::post('/period', 'Staff\PeriodController@index');
Route::post('/store_period', 'Staff\PeriodController@store');

// -----------------------------------work_type-----------------
Route::post('/work_type', 'Staff\WorkTypeController@index');
Route::post('/store_work_type', 'Staff\WorkTypeController@store');
// -----------------------------------work_system-----------------
Route::post('/work_system', 'Staff\WorkSystemController@index');
Route::post('/store_work_system', 'Staff\WorkSystemController@store');
// ---------------------------------attendance-----------------------------------------------
Route::post('/attend', 'Attendance\AttendanceController@show');
Route::post('/store_attendance', 'Attendance\AttendanceController@store');
Route::post('/attendance', 'Attendance\AttendanceController@index');
Route::post('/attendance_report', 'Attendance\AttendanceController@report');
Route::post('/attendance_report/search', 'Attendance\AttendanceController@search');
Route::post('/attendance/get_period/{id}', 'Attendance\AttendanceController@get_period');
Route::post('/attendance/get_staff/{id}', 'Attendance\AttendanceController@get_staff');
Route::post('/attendance/select_staff', 'Attendance\AttendanceController@select_staff');
Route::post('/attendance/get_time/{id}', 'Attendance\AttendanceController@get_time');

//  --------------------------------------------------------------------------
Route::post('/salary', 'Staff\SalaryController@index');
Route::post('/store_salary', 'Staff\SalaryController@store');
Route::post('/update_salary/{id}', 'Staff\SalaryController@update');
Route::post('/salary/{id}', 'Staff\SalaryController@edit');
Route::post('/delete_salary/{id}', 'Staff\SalaryController@destroy');

Route::post('/salarysearch', 'Staff\SalaryController@search');

Route::post('/salary_details', 'Staff\SalaryController@salary');
Route::post('/salary_details/{id}', 'Staff\SalaryController@salary_details');
Route::post('/salary', 'Staff\SalaryController@salary');
Route::post('/salary/select_staff', 'Staff\SalaryController@select_staff');
//  ----------------------------branch----------------------------------------

Route::post('/branch', 'Staff\BranchController@index');
Route::post('/create_branch', 'Staff\BranchController@create');
Route::post('/store_branch', 'Staff\BranchController@store');
Route::post('/update_branch/{id}', 'Staff\BranchController@update');
Route::post('/branch/{id}', 'Staff\BranchController@edit');
Route::post('/delete_branch/{id}', 'Staff\BranchController@destroy');
Route::post('/branchsearch', 'Staff\BranchController@search');

//  --------------------------------department------------------------------------
// Route::post('/department', 'DepartmentController@index');
// Route::post('/create_department', 'DepartmentController@create');
// Route::post('/store_department', 'DepartmentController@store');
// Route::post('/update_department/{id}', 'DepartmentController@update');
// Route::post('/department/{id}', 'DepartmentController@edit');
// Route::post('/delete_department/{id}', 'DepartmentController@destroy');
// Route::post('/departmentsearch', 'DepartmentController@search');

//  --------------------------------------job------------------------------

Route::post('/job', 'Staff\JobController@index');
Route::post('/create_job', 'Staff\JobController@create');
Route::post('/store_job', 'Staff\JobController@store');
Route::post('/update_job/{id}', 'Staff\JobController@update');
Route::post('/job/{id}', 'Staff\JobController@edit');
Route::post('/delete_job/{id}', 'Staff\JobController@destroy');
Route::post('/jobsearch', 'Staff\JobController@search');

//  ------------------------------staff_type--------------------------------------

Route::post('/staff_type', 'Staff\StaffTypeController@index');
Route::post('/create_staff_type', 'Staff\StaffTypeController@create');
Route::post('/store_staff_type', 'Staff\StaffTypeController@store');
Route::post('/update_staff_type/{id}', 'Staff\StaffTypeController@update');
Route::post('/staff_type/{id}', 'Staff\StaffTypeController@edit');
Route::post('/delete_staff_type/{id}', 'Staff\StaffTypeController@destroy');
Route::post('/staff_typesearch', 'Staff\StaffTypeController@search');

Route::post('/qualification', 'Staff\QualificationController@index');
Route::post('/create_qualification', 'Staff\QualificationController@create');
Route::post('/store_qualification', 'Staff\QualificationController@store');
Route::post('/update_qualification/{id}', 'Staff\QualificationController@update');
Route::post('/qualification/{id}', 'Staff\QualificationController@edit');
Route::post('/delete_qualification/{id}', 'Staff\QualificationController@destroy');
Route::post('/qualificationsearch', 'Staff\QualificationController@search');
//  ---------------------------------------nationality-----------------------------
Route::post('/nationality', 'NationalityController@index');
Route::post('/create_nationality', 'Staff\NationalityController@create');
Route::post('/store_nationality', 'Staff\NationalityController@store');
Route::post('/update_nationality/{id}', 'Staff\NationalityController@update');
Route::post('/nationality/{id}', 'Staff\NationalityController@edit');
Route::post('/delete_nationality/{id}', 'Staff\NationalityController@destroy');
Route::post('/nationalitysearch', 'Staff\NationalityController@search');
//  ---------------------------------------religion-----------------------------

Route::post('/religion', 'Staff\StaffReligionController@index');
Route::post('/create_religion', 'Staff\StaffReligionController@create');
Route::post('/store_religion', 'Staff\StaffReligionController@store');
Route::post('/update_religion/{id}', 'Staff\StaffReligionController@update');
Route::post('/religion/{id}', 'Staff\StaffReligionController@edit');
Route::post('/delete_religion/{id}', 'Staff\StaffReligionController@destroy');
Route::post('/religionsearch', 'Staff\StaffReligionController@search');
//  ---------------------------------------absence_type-----------------------------
Route::post('/absence_type', 'Absence\AbsenceController@index');
Route::post('/create_absence_type', 'Absence\AbsenceController@create');
Route::post('/storeabsence_type', 'Absence\AbsenceController@store');
Route::post('/update_absence_type/{id}', 'Absence\AbsenceController@update');
Route::post('/absence_type/{id}', 'Absence\AbsenceController@edit');
Route::post('/delete_absence_type/{id}', 'Absence\AbsenceController@destroy');
Route::post('/absence_typesearch', 'Absence\AbsenceController@search');
// --------------------------------------------------------------------------------
//  ---------------------------------------allowance_type-----------------------------
Route::post('/allowance', 'Staff\AllowanceController@index');
Route::post('/allowance_type', 'Staff\AllowanceTypeController@index');
Route::post('/create_allowance_type', 'Staff\AllowanceController@create');
Route::post('/store_allowance_type', 'Staff\AllowanceTypeController@store');
Route::post('/update_allowance_type/{id}', 'Staff\AllowanceController@update');
Route::post('/allowance_type/{id}', 'Staff\AllowanceController@edit');
Route::post('/delete_allowance_type/{id}', 'Staff\AllowanceController@destroy');
Route::post('/allowance_typesearch', 'Staff\AllowanceController@search');
Route::post('/store_allowance', 'Staff\AllowanceController@store');
// --------------------------------------------------------------------official_holiday--------------------
Route::post('/official_holiday', 'Staff\OfficialHolidayController@index');
Route::post('/create_official_holiday', 'Staff\OfficialHolidayController@create');

Route::post('/update_official_holiday/{id}', 'Staff\OfficialHolidayController@update');
Route::post('/official_holiday/{id}', 'Staff\OfficialHolidayController@edit');
Route::post('/delete_official_holiday/{id}', 'Staff\OfficialHolidayController@destroy');
Route::post('/official_holidaysearch', 'Staff\OfficialHolidayController@search');
//  ---------------------------------------allowance_type-----------------------------
Route::post('/extra_type', 'Extra\ExtraController@index');
Route::post('/extra_part', 'Extra\ExtraPartController@index');
Route::post('/create_extra_type', 'Extra\ExtraController@create');
Route::post('/storeextra_type', 'Extra\ExtraController@store');
Route::post('/update_extra_type/{id}', 'Extra\ExtraController@update');
Route::post('/extra_type/{id}', 'Extra\ExtraController@edit');
Route::post('/delete_extra_type/{id}', 'Extra\ExtraController@destroy');
Route::post('/extra_typesearch', 'Extra\ExtraController@search');

//  ---------------------------------------delay_type-----------------------------
Route::post('/delay_type', 'Delay\DelayController@index');
Route::post('/create_delay_type', 'Delay\DelayController@create');
Route::post('/storedelay_type', 'Delay\DelayController@store');
Route::post('/update_delay_type/{id}', 'Delay\DelayController@update');
Route::post('/delay_type/{id}', 'Delay\DelayController@edit');
Route::post('/delete_delay_type/{id}', 'Delay\DelayController@destroy');
Route::post('/delay_typesearch', 'Delay\DelayController@search');

Route::post('/delay_sanction', 'Delay\DelaySanctionController@index');
Route::post('/store_delay_sanction', 'Delay\DelaySanctionController@store');




// --------------------------------------------------------Absence---------------------------------------------------------------------
Route::post('/absence', 'Absence\AbsenceController@index');
Route::post('/store_absence', 'Absence\AbsenceController@store');
Route::post('/absence_sanction', 'Absence\AbsenceSanctionController@index');
Route::post('/store_absence_sanction', 'Absence\AbsenceSanctionController@store');

// --------------------------------------------------------Delay---------------------------------------------------------------------
Route::post('/delay', 'Delay\DelayController@index');
Route::post('/store_delay', 'Delay\DelayController@store');
// --------------------------------------------------------Extra---------------------------------------------------------------------
Route::post('/extra', 'Extra\ExtraController@index');
Route::post('/store_extra', 'Extra\ExtraController@store');
Route::post('/extra/select_staff', 'Extra\ExtraController@select_staff');
Route::post('/extra_sanction', 'Extra\ExtraSanctionController@index');
Route::post('/store_extra_sanction', 'Extra\ExtraSanctionController@store');
// --------------------------------------------------------Discount---------------------------------------------------------------------
Route::post('/discount', 'Staff\DiscountController@index');
Route::post('/store_discount', 'Staff\DiscountController@store');
Route::post('/discount/select_staff', 'Staff\DiscountController@select_staff');
// --------------------------------------------------------vacation_type---------------------------------------------------------------------

Route::post('/vacation_type', 'Staff\VacationTypeController@index');
Route::post('/store_vacation_type', 'Staff\VacationTypeController@store');
// --------------------------------------------------------Vacation---------------------------------------------------------------------
Route::post('/vacation', 'Staff\VacationController@index');
Route::post('/store_leave', 'Staff\VacationController@store');
Route::post('/vacation/select_staff', 'Staff\VacationController@select_staff');
Route::post('/leave_sanction', 'Leave\LeaveSanctionController@index');
Route::post('/store_leave_sanction', 'Leave\LeaveSanctionController@store');

// --------------------------------------------------------loan---------------------------------------------------------------------
Route::post('/loan', 'Staff\LoanController@index');
Route::post('/store_loan', 'Staff\LoanController@store');
// --------------------------------------------------------loan---------------------------------------------------------------------
Route::post('/advance', 'Staff\AdvanceController@index');
Route::post('/store_advance', 'Staff\AdvanceController@store');
Route::post('/advance/select_staff', 'Staff\AdvanceController@select_staff');

Route::post('/staff_sanction','Staff\StaffController@sanction');

Route::post('/staff_sanction_report','Staff\StaffController@sanction_report');

