<?php

namespace App\Services\core;
class CoreStaffAttendanceService
{



    public $updating_data;
    public $attendance_id;
    public $value;
    public $data;
    public $temporale_f;
    
    public function setValue($value){

        $this->value = $value;
    }

    
    public function setData($data){

        $this->data = $data;
    }
   

   
}
