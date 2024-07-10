<?php

namespace App\Services;
use App\Services\core\CoreStaffAttendanceService;
use Illuminate\Http\Request;

class AttendanceDetailService
{
    // use AttendanceTrait;
    public function __construct(
        protected CoreStaffAttendanceService $attendance_core,
        protected Request $request,
    ) {
    }


    function add_and_refresh_details()
    {

        $this->refresh_details();
        $this->init_details();
    }





    public function enter()
    {


        $this->attendance_core->updating_data = [
            // 'attendance_status' => $request->post('attendance_status')[$value],
            'check_in' => $this->attendance_core->data['time_in'][$this->attendance_core->value]

        ];
    }

    public function exit()
    {


        $this->attendance_core->updating_data = [
            // 'attendance_status' => $request->post('attendance_status')[$value],
            'check_in' => $this->attendance_core->data['time_in'][$this->attendance_core->value],
            'check_out' => $this->attendance_core->data['time_out'][$this->attendance_core->value],
            'delay' => $this->attendance_core->data['delay'][$this->attendance_core->value],
            'leave' => $this->attendance_core->data['leave'][$this->attendance_core->value],
            'extra' => $this->attendance_core->data['extra'][$this->attendance_core->value],
            'extra_after' => $this->attendance_core->data['extra_after'][$this->attendance_core->value],
            'duration' => $this->attendance_core->data['duration'][$this->attendance_core->value],
            // 'attendance_final' => $request->post('attendance_final')[$value]

        ];
    }




    public function init_details()
    {



        if (
            $this->attendance_core->data['attendance_in_out'] == 1 ||
            $this->attendance_core->data['attendance_in_out'] == 2
        ) {


            if ($this->attendance_core->attendance_details_id == 0) {


                $this->attendance_core->init_details_table(
                    $this->attendance_core->data,
                    $this->attendance_core->attendance_id,
                    $this->attendance_core->value
                );
            }
        }

        if (
            $this->attendance_core->data['attendance_in_out'] == 2 &&
            $this->attendance_core->attendance_details_id == 0
        ) {


            $this->attendance_core->init_details_table(
                $this->attendance_core->data,
                $this->attendance_core->attendance_id,
                $this->attendance_core->value
            );

            if ($this->attendance_core->data['sort_period'] == 2) {

                $this->sanction();
            }
        }
    }


    public function refresh_details()
    {



        $this->attendance_core->refresh_details_table();

        if (
            $this->attendance_core->data['attendance_in_out'] == 2 &&
            $this->attendance_core->attendance_details_id != 0 &&
            $this->attendance_core->data['sort_period'] == 2
        ) {



            $this->sanction();
        }
    }




    public function sanction()
    {


        if (
            $this->attendance_core->data['attendance_final'] == 'complete'
            // && $this->attendance_core->data['code'] == 'B'
        ) {

            foreach (config('sanction.data_sanction') as $value_sanction) {

                if ($value_sanction != 'absence_sanction') {



                    app($value_sanction)->create();

              
                }
            }
        }
    }
}
