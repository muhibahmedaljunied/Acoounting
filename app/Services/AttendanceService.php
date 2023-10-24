<?php

namespace App\Services;

use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Traits\staff\AttendanceTrait;
use App\Services\core\CoreStaffAttendanceService;
use App\Services\AttendanceDetailService;
use Illuminate\Http\Request;
use DB;

class AttendanceService
{

    use AttendanceTrait;
    public function __construct(

        protected DetailRepositoryInterface $details,
        protected CoreStaffAttendanceService $attendance_core,
        protected AttendanceDetailService $details_service,
        protected HRRepositoryInterface $hr,


        protected Request $request,
    ) {

        $this->attendance_core->data = $request->all();
    }

    public function absence()
    {


        $this->get_attendance();

        if ($this->attendance_core->attendance_id == 0) {

            $this->attendance_core->attendance_id = $this->add_into_attendance_table();

            $this->sanction();
        }
    }

    public function attende()
    {

        $this->check_attendance();
        $this->get_attendance();
        $this->add_attendance();
        $this->details_service->add_and_refresh_details();
    }


    public function add_attendance()
    {

        ($this->attendance_core->attendance_id == 0) ?$this->add_into_attendance_table() : $this->refresh_attendance_table();



    }


    public function check_attendance()
    {


        // dd($this->attendance_core->value);
        if ($this->attendance_core->data['attendance_in_out'] == 1) {

            $this->attendance_core->updating_data = [
                // 'attendance_status' => $request->post('attendance_status')[$value],
                'check_in' => $this->attendance_core->data['time_in'][$this->attendance_core->value]

            ];
        } else {

            $this->attendance_core->updating_data = [
                // 'attendance_status' => $request->post('attendance_status')[$value],
                'check_in' => $this->attendance_core->data['time_in'][$this->attendance_core->value],
                'check_out' => $this->attendance_core->data['time_out'][$this->attendance_core->value],
                'delay' => $this->attendance_core->data['delay'][$this->attendance_core->value],
                'leave' => $this->attendance_core->data['leave'][$this->attendance_core->value],
                'extra' => $this->attendance_core->data['extra'][$this->attendance_core->value],
                'duration' => $this->attendance_core->data['duration'][$this->attendance_core->value],
                // 'attendance_final' => $request->post('attendance_final')[$value]

            ];
        }
    }


    public function get_attendance()
    {



        $attendance_id  =  $this->get_from_attendance_table(
            $this->attendance_core->data['attendance_date'],
            $this->attendance_core->data['staff'][$this->attendance_core->value]
        );

        $this->return_attendance_id($attendance_id);
    }



    function return_attendance_id($attendance_id)
    {



        if ($attendance_id->isEmpty()) {

            $this->attendance_core->attendance_id = 0;
        } else {


            foreach ($attendance_id as $values) {

                $this->attendance_core->attendance_id = $values['id'];
            }


        }
    }


    
    public function sanction()
    {


        // $this->update($attendance_id); //this must be observer

        foreach (config('sanction.data_sanction') as $value_sanction) {

            $repo = app(SanctionRepositoryInterface::class)
                ->get($value_sanction)
                ->create(

                    $this->attendance_core->attendance_id,
                    $this->attendance_core->data,
                    $this->attendance_core->value,
                    $value_sanction
                );
        }
    }


}
