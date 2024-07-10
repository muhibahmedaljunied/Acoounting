<?php

namespace App\Services;
// use App\Traits\staff\AttendanceTrait;
use App\Services\core\CoreStaffAttendanceService;
use App\Services\AttendanceDetailService;
use Illuminate\Http\Request;

class AttendanceService
{

    // use AttendanceTrait;
    public function __construct(

        protected CoreStaffAttendanceService $attendance_core,
        protected AttendanceDetailService $details_service,
        protected Request $request,
    ) {
    }

    // public function absence()
    // {


    //     $this->get_attendance();

    //     if ($this->attendance_core->attendance_id == 0) {

    //         $this->attendance_core->attendance_id = $this->attendance_core->add_into_attendance_table();

    //         $this->details_service->sanction();
    //     }
    // }

    public function attende()
    {


        $this->check_attendance();
        $this->get_attendance();
        $this->add_attendance();
        $this->details_service->add_and_refresh_details();
    }


    public function add_attendance()
    {


// dd($this->attendance_core->data['attendance_final']);
        ($this->attendance_core->attendance_id == 0) ? $this->attendance_core->add_into_attendance_table()
            :
            $this->attendance_core->refresh_attendance_table();
    }

    public function check_attendance()
    {

        ($this->attendance_core->data['attendance_in_out'] == 1) ? $this->details_service->enter() : $this->details_service->exit();
    }


    public function get_attendance()
    {


        $this->attendance_core->get_from_attendance_table();
        $this->return_attendance_id();
    }



    function return_attendance_id()
    {



        if ($this->attendance_core->attendance_id->isEmpty()) {

            $this->attendance_core->attendance_id = 0;
        } else {


            foreach ($this->attendance_core->attendance_id as $values) {

                $this->attendance_core->attendance_id = $values['id'];
            }
        }
    }





}
