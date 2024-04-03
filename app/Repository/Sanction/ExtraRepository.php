<?php

namespace App\Repository\Sanction;

use App\Traits\staff\Sanction\ExtraSanctionTrait;
use App\Services\core\CoreStaffAttendanceService;
use App\Repository\HR\ExtraRepository as lRepository ;


class ExtraRepository
{
    use ExtraSanctionTrait;
    public $attendance;
    public $attendance_all;
    public $total_extra = 0;
    public $total_extra_after = 0;

    public function __construct(
        protected CoreStaffAttendanceService $attendance_core,
        protected lRepository $hr,

    ) {

        $this->attendance_core->init('extra', 'ExtraSanction');
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


        $this->get();


        foreach ($this->attendance_core->data_sanction as $key => $value) {


            // dd('e',$this->attendance_core->data['time_out'][$this->attendance_core->value]);

            if (
                $value->code == 'befor_work' &&
                $this->attendance_core->iterat == $value->iteration
            ) {



                $this->attendance_core->sanction_type_id = $value->extra_sanction_id;
                $this->init_data_store($value);
                $this->hr->store();
                $this->attendance_core->handle_sanction();
                // $this->attendance_core->payroll();
            }

            // -------------------------------


            if ($value->code == 'after_work') {

                $this->attendance_core->type = 'extra_after';
                if (
                    $this->attendance_core->iterat == $value->iteration
                ) {
    
    
                    $this->calc_total_for_current();
                    $this->calc_total_for_all();
    
                    $this->attendance_core->sanction_type_id = $value->extra_sanction_id;
                    $this->init_data_store($value);
                    $this->hr->store();
                    $this->attendance_core->handle_sanction();
                    // $this->attendance_core->payroll();
                    // }
                }
            }
         
        }
    }


    public function calc_total_for_current()
    {

        $this->attendance = $this->attendance_core->current_attendance();

        foreach ($this->attendance as $key => $total) {

            $this->total_extra = 0;
            $this->total_extra_after = 0;


            foreach ($total->attendance_details as $value_delay_sub) {

                $this->total_extra += $value_delay_sub->extra;
                $this->total_extra_after += $value_delay_sub->extra_after;
            }
        }



    }


    public function calc_total_for_all()
    {

        $this->attendance_all =  $this->attendance_core->all_attendance();


        $count = 0;
        foreach ($this->attendance_all as $key => $total) {


            $total_extra = 0;
            $total_extra_after = 0;

            foreach ($total->attendance_details as $value_delay_sub) {


                $total_extra += $value_delay_sub->extra;
                $total_extra_after += $value_delay_sub->extra_after;
            }



            if ($this->attendance_core->type == 'extra' && $this->total_extra == $total_extra) {


                $count += 1;
            }

            if ($this->attendance_core->type == 'extra_after' && $this->total_extra_after == $total_extra_after) {


                $count += 1;
            }
        }





        $this->attendance_core->iterat = $count;

   
    }

 

    public function init_data_store($value)
    {


        $this->hr->staff_id = $this->attendance_core->data['staff'][$this->attendance_core->value];
        $this->hr->extra_type_id = $value->extra_type_id;
        $this->hr->date = $this->attendance_core->data['attendance_date'];
        $this->hr->start_time = $this->attendance_core->data['time_in'][$this->attendance_core->value];
        $this->hr->end_time = $this->attendance_core->data['time_out'][$this->attendance_core->value];
        $this->hr->number_hours = $value->duration;
    }
}
