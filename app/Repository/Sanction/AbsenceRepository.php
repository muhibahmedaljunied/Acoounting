<?php

namespace App\Repository\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Traits\staff\Sanction\AbsenceSanctionTrait;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;
class AbsenceRepository implements SanctionRepositoryInterface {

    use SanctionTrait,AbsenceSanctionTrait;
    public $attendance_core;

    public function create($attendance_core)
    {

        $this->attendance_core = $attendance_core;
        $data  = $this->get();
        $day = date('l', strtotime($attendance_core->data['attendance_date']));
        $this->current_attendance($attendance_core->attendance_id,'absence');
        $iterat = $this->all_attendance('absence');
        foreach ($data as $key => $value) {
     
            if ($value->absence_type_id == 1 &&  $day == 'Saturday') {

          
                if ($iterat == $value->iteration) {
                   
                    $this->handle();

              
                }
            }
         
        }
    
    }


    public function handle(){

     
        $this->get_sanction('AbsenceSanction');
        $this->staff_sanction();
        // $this->payroll();


    }
   
   
}