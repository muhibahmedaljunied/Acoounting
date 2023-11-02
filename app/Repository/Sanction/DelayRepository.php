<?php

namespace App\Repository\Sanction;

use App\Traits\Staff\Sanction\SanctionTrait;
use App\Traits\staff\Sanction\DelaySanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use DB;

class DelayRepository implements SanctionRepositoryInterface
{
    use SanctionTrait, DelaySanctionTrait;

    public $attendance_core;

    public function create($attendance_core)
    {

        $this->attendance_core = $attendance_core;
        $data  = $this->get();
  
        $day = date('l', strtotime($attendance_core->data['attendance_date']));

        $this->current_attendance('delay');
           
        $iterat = $this->all_attendance('delay');
    
        foreach ($data as $key => $value) {

            // if ($value->code == $attendance_core->data['type_leave_delay'] && $value->duration == $attendance_core->data['delay'][$attendance_core->value]) {
                // dd($value);
               
            if ($value->delay_type_id == 1 &&  $day == 'Saturday') {
            
    
                if ($iterat == $value->iteration) {
            
                    $attendance_core->sanction_type_id = $value->delay_type_id;
                    $this->handle();
                }
            }
        }
        // dd('sdd');
    }



    public function handle()
    {

 
        $this->get_sanction('DelaySanction');
        $this->staff_sanction();
        // $this->payroll();
    }
}
