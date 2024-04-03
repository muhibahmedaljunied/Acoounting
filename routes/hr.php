<?php
use Illuminate\Support\Facades\Route;

Route::post('/store_account_setting', 'Staff\staffController@store_account_setting');
Route::post('/store_staff_account_setting', 'Staff\staffController@store_staff_account_setting');
Route::post('/get_staff_account_setting', 'Staff\staffController@get_staff_account_setting');


// ---------------------------------------------------------------------------------
Route::post('/tree_structure', 'Staff\AdministrativeStructureController@tree_structure');
Route::post('/structure_details_node/{id}', 'Staff\AdministrativeStructureController@structure_details_node');
Route::post('/tree_job', 'Staff\AdministrativeStructureController@tree_structure');
Route::post('/store_structure', 'Staff\AdministrativeStructureController@store');
Route::post('/delete_structure/{id}', 'Staff\AdministrativeStructureController@destroy');
/* --------------------------------staff---------------------------------------------------------*/
Route::post('/staff', 'Staff\StaffController@index');
// Route::post('/staff_delete/{id}', 'Staff\StaffController@destroy');
Route::post('/staff/{id}', 'Staff\StaffController@select_staff');
Route::post('store_staff', 'Staff\StaffController@store');
Route::post('/update_staff/{id}', 'Staff\StaffController@update');
Route::post('/staff/{id}', 'Staff\StaffController@edit');
Route::post('/delete_staff/{id}', 'Staff\StaffController@destroy');
Route::post('/staff/select_staff', 'Staff\StaffController@select_staff');

Route::post('/staffsearch', 'Staff\StaffController@search');
Route::post('/staff/get_job/{id}', 'Staff\StaffController@get_job');
// -------------------------------------staff_work--------------------------------------------------------------------
Route::post('/staff_work', 'Staff\StaffController@index');
Route::post('/store_staff_work', 'Staff\StaffWorkController@store');

/* -----------------------------------period-----------------*/
Route::post('/period', 'Staff\PeriodController@index');
Route::post('/period_time', 'Staff\PeriodController@get_period_time');
Route::post('/store_period_time', 'Staff\PeriodController@store_period_time');
Route::post('/store_period', 'Staff\PeriodController@store_period');

/* -----------------------------------work_type-----------------*/
Route::post('/work_type', 'Staff\WorkTypeController@index');
Route::post('/store_work_type', 'Staff\WorkTypeController@store');
/* -----------------------------------work_system-----------------*/
Route::post('/get_period_time/{id}', 'Staff\WorkSystemController@get_period_time');
Route::post('/work_system', 'Staff\WorkSystemController@index');
Route::post('/store_work_system', 'Staff\WorkSystemController@store');
/* -----------------------------------work_system_type-----------------*/
Route::post('/work_system_type', 'Staff\WorkSystemTypeController@index');
Route::post('/store_work_system_type', 'Staff\WorkSystemTypeController@store');
/* ---------------------------------attendance-----------------------------------------------*/
Route::post('/attend', 'Attendance\AttendanceController@show');
Route::post('/store_attendance', 'Attendance\AttendanceController@store');
Route::post('/attendance', 'Attendance\AttendanceController@index');
Route::post('/attendance_report', 'Attendance\AttendanceController@report');
Route::post('/attendance_report/search', 'Attendance\AttendanceController@search');
Route::post('/attendance/get_period/{id}', 'Attendance\AttendanceController@get_period');
Route::post('/attendance/get_staff/{id}', 'Attendance\AttendanceController@get_staff');
Route::post('/attendance/select_staff', 'Attendance\AttendanceController@select_staff');
Route::post('/attendance/get_time/{id}', 'Attendance\AttendanceController@get_time');

/*  --------------------------------------------------------------------------*/
Route::post('/salary', 'Staff\SalaryController@index');
Route::post('/store_salary', 'Staff\SalaryController@store');
Route::post('/prove_salary/{id}', 'Staff\SalaryController@prove_salary');
Route::post('/prove_all_salary', 'Staff\SalaryController@prove_all_salary');
Route::post('/paid_salary/{id}', 'Staff\SalaryController@paid_salary');
Route::post('/paid_all_salary', 'Staff\SalaryController@paid_all_salary');
Route::post('/update_salary/{id}', 'Staff\SalaryController@update');
Route::post('/salary/{id}', 'Staff\SalaryController@edit');
Route::post('/delete_salary/{id}', 'Staff\SalaryController@destroy');

Route::post('/salarysearch', 'Staff\SalaryController@search');

Route::post('/salary_details', 'Staff\SalaryController@salary');
Route::post('/salary_details/{id}', 'Staff\SalaryController@salary_details');
Route::post('/salary', 'Staff\SalaryController@salary');
Route::post('/salary/select_staff', 'Staff\SalaryController@select_staff');
/*  ----------------------------branch----------------------------------------*/

Route::post('/branch', 'Staff\BranchController@index');
Route::post('/create_branch', 'Staff\BranchController@create');
Route::post('/store_branch', 'Staff\BranchController@store');
Route::post('/update_branch/{id}', 'Staff\BranchController@update');
Route::post('/branch/{id}', 'Staff\BranchController@edit');
Route::post('/delete_branch/{id}', 'Staff\BranchController@destroy');
Route::post('/branchsearch', 'Staff\BranchController@search');


/*  --------------------------------------job------------------------------*/

Route::post('/job', 'Staff\JobController@index');
Route::post('/create_job', 'Staff\JobController@create');
Route::post('/store_job', 'Staff\JobController@store');
Route::post('/update_job/{id}', 'Staff\JobController@update');
Route::post('/job/{id}', 'Staff\JobController@edit');
Route::post('/delete_job/{id}', 'Staff\JobController@destroy');
Route::post('/jobsearch', 'Staff\JobController@search');

/*  ------------------------------staff_type--------------------------------------*/

Route::post('/staff_type', 'Staff\StaffTypeController@index');
Route::post('/staff_work_system', 'Staff\StaffWorkController@index');
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
/*  ---------------------------------------nationality-----------------------------*/
Route::post('/nationality', 'Staff\NationalityController@index');
Route::post('/create_nationality', 'Staff\NationalityController@create');
Route::post('/store_nationality', 'Staff\NationalityController@store');
Route::post('/update_nationality/{id}', 'Staff\NationalityController@update');
Route::post('/nationality/{id}', 'Staff\NationalityController@edit');
Route::post('/delete_nationality/{id}', 'Staff\NationalityController@destroy');
Route::post('/nationalitysearch', 'Staff\NationalityController@search');
/*  ---------------------------------------religion-----------------------------*/

Route::post('/religion', 'Staff\StaffReligionController@index');
Route::post('/create_religion', 'Staff\StaffReligionController@create');
Route::post('/store_religion', 'Staff\StaffReligionController@store');
Route::post('/update_religion/{id}', 'Staff\StaffReligionController@update');
Route::post('/religion/{id}', 'Staff\StaffReligionController@edit');
Route::post('/delete_religion/{id}', 'Staff\StaffReligionController@destroy');
Route::post('/religionsearch', 'Staff\StaffReligionController@search');
/*  ---------------------------------------absence_type-----------------------------*/
Route::post('/absence_type', 'Absence\AbsenceController@index');
Route::post('/create_absence_type', 'Absence\AbsenceController@create');
Route::post('/storeabsence_type', 'Absence\AbsenceController@store');
Route::post('/update_absence_type/{id}', 'Absence\AbsenceController@update');
Route::post('/absence_type/{id}', 'Absence\AbsenceController@edit');
Route::post('/delete_absence_type/{id}', 'Absence\AbsenceController@destroy');
Route::post('/absence_typesearch', 'Absence\AbsenceController@search');


/* --------------------------------------------------------------------------------*/
/*  ---------------------------------------allowance_type-----------------------------*/
Route::post('/allowance', 'Staff\AllowanceController@index');
Route::post('/allowance_type', 'Staff\AllowanceTypeController@index');
Route::post('/create_allowance_type', 'Staff\AllowanceController@create');
Route::post('/store_allowance_type', 'Staff\AllowanceTypeController@store');
Route::post('/update_allowance_type/{id}', 'Staff\AllowanceController@update');
Route::post('/allowance_type/{id}', 'Staff\AllowanceController@edit');
Route::post('/delete_allowance_type/{id}', 'Staff\AllowanceController@destroy');
Route::post('/allowance_typesearch', 'Staff\AllowanceController@search');
Route::post('/store_allowance', 'Staff\AllowanceController@store');
/* --------------------------------------------------------------------official_holiday--------------------*/
Route::post('/official_holiday', 'Staff\OfficialHolidayController@index');
Route::post('/create_official_holiday', 'Staff\OfficialHolidayController@create');

Route::post('/update_official_holiday/{id}', 'Staff\OfficialHolidayController@update');
Route::post('/official_holiday/{id}', 'Staff\OfficialHolidayController@edit');
Route::post('/delete_official_holiday/{id}', 'Staff\OfficialHolidayController@destroy');
Route::post('/official_holidaysearch', 'Staff\OfficialHolidayController@search');
/*  ---------------------------------------allowance_type-----------------------------*/
Route::post('/extra_type', 'Extra\ExtraController@index');
Route::post('/extra_part', 'Extra\ExtraPartController@index');
Route::post('/create_extra_type', 'Extra\ExtraController@create');
Route::post('/storeextra_type', 'Extra\ExtraController@store');
Route::post('/update_extra_type/{id}', 'Extra\ExtraController@update');
Route::post('/extra_type/{id}', 'Extra\ExtraController@edit');
Route::post('/delete_extra_type/{id}', 'Extra\ExtraController@destroy');
Route::post('/extra_typesearch', 'Extra\ExtraController@search');

/*  ---------------------------------------delay_type-----------------------------*/
Route::post('/delay_type', 'Delay\DelayController@index');
Route::post('/create_delay_type', 'Delay\DelayController@create');
Route::post('/storedelay_type', 'Delay\DelayController@store');
Route::post('/update_delay_type/{id}', 'Delay\DelayController@update');
Route::post('/delay_type/{id}', 'Delay\DelayController@edit');
Route::post('/delete_delay_type/{id}', 'Delay\DelayController@destroy');
Route::post('/delay_typesearch', 'Delay\DelayController@search');
/* --------------------------------------------------------Absence---------------------------------------------------------------------*/
Route::post('/absence', 'Absence\AbsenceController@index');
Route::post('/staff_absence', 'Absence\AbsenceController@get_staff_absence');
// Route::post('/store_staff_absence', 'Absence\AbsenceController@store_staff_absence');
Route::post('/store_absence', 'Absence\AbsenceController@store');
Route::post('/change_status_absence_sanction', 'Absence\AbsenceSanctionController@change_status');
Route::post('/absence_sanction', 'Absence\AbsenceSanctionController@index');
Route::post('/store_absence_sanction', 'Absence\AbsenceSanctionController@store');
Route::post('/staff_absence_sanction','Absence\AbsenceSanctionController@get_staff_absence_sanction');
/* --------------------------------------------------------Delay---------------------------------------------------------------------*/
Route::post('/delay', 'Delay\DelayController@index');
Route::post('/staff_delay', 'Delay\DelayController@get_staff_delay');
// Route::post('/store_staff_delay', 'Delay\DelayController@store_staff_delay');
Route::post('/store_delay', 'Delay\DelayController@store');
Route::post('/change_status_delay_sanction', 'Delay\DelaySanctionController@change_status');
Route::post('/delay_sanction', 'Delay\DelaySanctionController@index');
Route::post('/store_delay_sanction', 'Delay\DelaySanctionController@store');
Route::post('/staff_delay_sanction','Delay\DelaySanctionController@get_staff_delay_sanction');
/* --------------------------------------------------------Extra---------------------------------------------------------------------*/
Route::post('/extra', 'Extra\ExtraController@index');
Route::post('/store_extra', 'Extra\ExtraController@store');
Route::post('/extra/select_staff', 'Extra\ExtraController@select_staff');
Route::post('/change_status_extra_sanction', 'Extra\ExtraSanctionController@change_status');
Route::post('/extra_sanction', 'Extra\ExtraSanctionController@index');
Route::post('/store_extra_sanction', 'Extra\ExtraSanctionController@store');
Route::post('/staff_extra_sanction','Extra\ExtraSanctionController@get_staff_extra_sanction');
/* --------------------------------------------------------Discount---------------------------------------------------------------------*/
Route::post('/discount', 'Staff\DiscountController@index');
Route::post('/discount_report', 'Staff\DiscountController@report');
Route::post('/store_discount', 'Staff\DiscountController@store');
Route::post('/discount/select_staff', 'Staff\DiscountController@select_staff');
/* --------------------------------------------------------vacation_type---------------------------------------------------------------------*/

Route::post('/vacation_type', 'Staff\VacationTypeController@index');
Route::post('/store_vacation_type', 'Staff\VacationTypeController@store');
/* --------------------------------------------------------Vacation---------------------------------------------------------------------*/
Route::post('/staff_vacation', 'Staff\VacationController@index');
Route::post('/vacation_report', 'Staff\VacationController@report');
Route::post('/store_vaction', 'Staff\VacationController@store');
Route::post('/vacation/select_staff', 'Staff\VacationController@select_staff');
// --------------------------------------------------------------------
Route::post('/staff_leave', 'Leave\LeaveController@get_staff_leave');
// Route::post('/store_staff_leave', 'Leave\LeaveController@store_staff_leave');
Route::post('/store_leave', 'Leave\LeaveController@store');
Route::post('/change_status_leave_sanction', 'Leave\LeaveSanctionController@change_status');
Route::post('/leave_sanction', 'Leave\LeaveSanctionController@index');
Route::post('/store_leave_sanction', 'Leave\LeaveSanctionController@store');
Route::post('/staff_leave_sanction','Leave\LeaveSanctionController@get_staff_leave_sanction');

/* --------------------------------------------------------loan---------------------------------------------------------------------*/
Route::post('/loan', 'Staff\LoanController@index');
Route::post('/store_loan', 'Staff\LoanController@store');
/* --------------------------------------------------------loan---------------------------------------------------------------------*/
Route::post('/advance', 'Staff\AdvanceController@index');
Route::post('/store_advance', 'Staff\AdvanceController@store');
Route::post('/advance/select_staff', 'Staff\AdvanceController@select_staff');
Route::post('/advance_report', 'Staff\AdvanceController@report');
Route::post('/staff_sanction','Staff\StaffController@sanction');

Route::post('/staff_sanction_report','Staff\StaffController@sanction_report');

