<?php

namespace App\Services\core;
class CoreStaffAttendanceService
{


    // public $extra_type_id;
    // public $leave_type_id;
    // public $absence_type_id;
    // public $delay_type_id;
    // public $sanction_type_id;
    public $temporale_f;
    public $updating_data;
    public $attendance_id;
    public $value;
    public $data;
    public $sanction;
    
   
    public function setValue($value){

        $this->value = $value;
    }

    
    public function setData($data){

        $this->data = $data;
    }
   

   
}
