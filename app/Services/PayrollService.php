<?php

namespace App\Services;

use App\Models\Payroll;
use App\Services\core\CoreStaffAttendanceService;

class PayrollService
{

    public function __construct(


        protected CoreStaffService $core,
        protected CoreStaffAttendanceService $core_attendance,


    ) {
    }
    public function payroll($delay_sanction)
    {


        if ($this->core->data['status'] == 1) {

            tap(Payroll::where('staff_id', $this->core->data['staff']))
                ->increment($delay_sanction, $this->core->data['sanction'])
                ->get();
        }
    }


    // public function refresh_payroll_for_hr()
    // {
    //     tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
    //         ->update($this->core->data_of_hr_for_update_payroll)
    //         ->get('id');
       
    // }

    public function refresh_payroll_status($staff,$status){


        tap(Payroll::where(['staff_id' => $staff]))
        ->update(['status' => $status])
        ->get('id');


    }

    public function refresh_payroll_for_attendance_sanction($total = 'total_sanction')
    {

        if ($this->core_attendance->sanction != null) {


            tap(Payroll::where('staff_id', $this->core_attendance->data['staff'][0]))
            ->increment($total, $this->core_attendance->sanction->sanction)
            ->get();
      
        }

     
    }

}
