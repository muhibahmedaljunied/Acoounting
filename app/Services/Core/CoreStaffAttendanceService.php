<?php

namespace App\Services\core;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\Traits\staff\AttendanceTrait;
class CoreStaffAttendanceService
{
    use SanctionTrait,AttendanceTrait;

    public $attendance_details_id = 0;
    public $sanction_type_id;
    public $data_sanction;
    public $temporale_f;
    public $updating_data;
    public $attendance_id;
    public $value;
    public $data;
    public $sanction;
    public $iterat;
    public $type;
    public $table;
    public $day;

   
    public function init($type,$table){

        $this->setDay();
        $this->setType($type);
        $this->setTable($table);
    }
    public function handle_sanction(){
    

        $this->get_sanction();

        $this->staff_sanction();
    }

    
    public function setValue($value){

        $this->value = $value;
    }

    
    public function setData($data){

        $this->data = $data;
    }
    

    public function setDay(){

        $this->day = date('l', strtotime($this->data['attendance_date']));
    }

    public function setType($type){

        $this->type = $type;
    }
   

    public function setTable($table){

        $this->table = $table;
    }
   

   
}
