<?php

namespace App\Repository\Sanction;
use App\Services\core\CoreStaffAttendanceService;
use App\Traits\staff\Sanction\LeaveSanctionTrait;
use App\Repository\HR\LeaveRepository as lRepository ;
class LeaveRepository
{
    use LeaveSanctionTrait;
    public $attendance;
    public $attendance_all;
    public $total_leave;
    public function __construct(
        protected CoreStaffAttendanceService $attendance_core,
        protected lRepository $hr,

    ) {

        $this->attendance_core->init('leave', 'LeaveSanction');
    }


    public function create()
    {

        $this->get();
        $this->calc_total_for_current($this->attendance);
        $this->calc_total_for_all($this->attendance_all);
        $this->options();
    }
    public function options()
    {

        // dd($this->attendance_core->data_sanction);
        foreach ($this->attendance_core->data_sanction as $key => $value) {


         
            if ($value->code == 'sat' &&  $this->attendance_core->day == 'Saturday') {

                if ($this->attendance_core->iterat == $value->iteration) {

                    $this->attendance_core->sanction_type_id = $value->leave_sanction_id;
                    $this->init_data_store($value);
                    $this->hr->store();
                    $this->attendance_core->handle_sanction();
                    // $this->attendance_core->payroll();
                 
                }
            }
        }
    }

    public function calc_total_for_current()
    {

        $this->attendance = $this->attendance_core->current_attendance();
        foreach ($this->attendance as $key => $total) {

            $this->total_leave = 0;


            foreach ($total->attendance_details as $value_leave_sub) {


                $this->total_leave += $value_leave_sub->leave;            }
        }

    }


    public function calc_total_for_all()
    {

        $count = 0;
        $this->attendance_all =  $this->attendance_core->all_attendance();
        foreach ($this->attendance_all as $key => $total) {


            $total_leave = 0;
            foreach ($total->attendance_details as $value_leave_sub) {


                $total_leave += $value_leave_sub->leave;
            }



            if ($this->total_leave == $total_leave) {


                $count += 1;
            }

          
        }
        $this->attendance_core->iterat = $count;

   
    }

    public function init_data_store($value)
    {


        $this->hr->staff_id = $this->attendance_core->data['staff'][$this->attendance_core->value];
        $this->hr->leave_type_id = $value->leave_type_id;
        $this->hr->part_id = $value->part_id;
        $this->hr->date = $this->attendance_core->data['attendance_date'];
    }
}
