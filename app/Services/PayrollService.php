<?php

namespace App\Services;

use App\Models\Payroll;

class PayrollService
{

    public function __construct(


        protected CoreStaffService $core,


    ) {
    }
    public function payroll()
    {


        if ($this->core->data['status'] == 1) {

            tap(Payroll::where('staff_id', $this->core->data['staff']))
                ->increment('total_absence_sanction', $this->core->data['sanction'])
                ->get();
        }
    }


    public function refresh_payroll_for_hr()
    {
        tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
            ->update($this->core->data_of_hr_for_update_payroll)
            ->get('id');
       
    }
}
