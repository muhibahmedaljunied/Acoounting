<?php

namespace App\Services;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\staff\AttendanceTrait;
use App\Services\core\CoreStaffAttendanceService;
use Illuminate\Http\Request;
use DB;

class AttendanceDetailService
{

    use AttendanceTrait;
    public function __construct(
        protected DetailRepositoryInterface $details,
        protected CoreStaffAttendanceService $attendance_core,
        protected Request $request,
    ) {

        $this->attendance_core->data = $request->all();
    }


    function add_and_refresh_details()
    {
        // $this->add_attendance();
        $this->refresh_details();

        $this->init_details();
    }

    public function refresh_details()
    {


        // if ($this->attendance_core->attendance_id != 0) {

            if ($this->attendance_core->data['attendance_in_out'] == 2) {

            $this->refresh_details_table(
                $this->attendance_core->data['period'],
                $this->attendance_core->updating_data,
                $this->attendance_core->attendance_id
            );


            // if ($request->post('attendance_final') == 'complete') {

            //     $this->sanction();
            // }
        }
    }


    public function init_details()
    {


        // if ($this->attendance_core->temporale_f->isEmpty() || $this->attendance_core->attendance_id == 0) {
            if ($this->attendance_core->data['attendance_in_out'] == 1) {

                // dd($this->attendance_core->data);
            $this->init_details_table(
                 $this->attendance_core->data,
                $this->attendance_core->attendance_id,
                 $this->attendance_core->value
            );
        }
    }


}
