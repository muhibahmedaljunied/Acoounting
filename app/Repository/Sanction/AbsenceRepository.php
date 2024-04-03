<?php
namespace App\Repository\Sanction;
use App\Services\core\CoreStaffAttendanceService;
use App\Traits\staff\Sanction\AbsenceSanctionTrait;
class AbsenceRepository 
{
    
    use AbsenceSanctionTrait;
    public $attendance;
    public $attendance_all;
    public function __construct(
        protected CoreStaffAttendanceService $attendance_core,
    ) {


        $this->attendance_core->init('absence','AbsenceSanction');
      

    }
    public function create()
    {
        $this->get();
        $this->attendance_core->get_sanction();
        $this->calc_total_for_current($this->attendance);
        $this->calc_total_for_all($this->attendance_all);
        $this->options();
  
    }

    public function options(){



   

        foreach ($this->attendance_core->data_sanction as $key => $value) {
     
            if ($value->code == 'sat' &&  $this->attendance_core->day == 'Saturday') {

          
                if ($this->attendance_core->iterat == $value->iteration) {

                    $this->attendance_core->handle();
                
                }
            }
         
        }
    }


    public function calc_total_for_current()
    {

        $this->attendance = $this->attendance_core->current_attendance();

        foreach ($this->attendance as $key => $total) {

            $this->attendance_core->total_extra = 0;
            $this->attendance_core->total_extra_after = 0;
            $this->attendance_core->total_duration = 0;


            foreach ($total->attendance_details as $value_delay_sub) {



                $this->attendance_core->total_extra += $value_delay_sub->extra;
                $this->attendance_core->total_extra_after += $value_delay_sub->extra_after;
                $this->attendance_core->total_duration += $value_delay_sub->duration;
            }
        }
    }


    public function calc_total_for_all()
    {

        $this->attendance_all =  $this->attendance_core->all_attendance();


        $count = 0;
        foreach ($this->attendance_all as $key => $total) {


            $this->attendance_core->total_extra = 0;
            $this->attendance_core->total_extra_after = 0;
            $this->attendance_core->total_duration = 0;



            foreach ($total->attendance_details as $value_delay_sub) {


                $this->attendance_core->total_extra += $value_delay_sub->extra;
                $this->attendance_core->total_extra_after = $value_delay_sub->extra_after;
                $this->attendance_core->total_duration += $value_delay_sub->duration;
            }



            if ($this->attendance_core->type == 'extra' && $this->attendance_core->duration == $total->total_extra) {


                $count += 1;
            }

            if ($this->attendance_core->type == 'extra_after' && $this->attendance_core->duration == $total->total_extra_after) {


                $count += 1;
            }
        }





        $this->attendance_core->iterat = $count;

   
    }
   
}