<?php

namespace App\Repository\HR;
use App\RepositoryInterface\AttendanceRepositoryInterface;
use DB;
class AttendRepository implements AttendanceRepositoryInterface
{

    public function handle($request, $value)
    {


        $updating_data = $this->check_attendance($request, $value);
        $attendance_id = $this->get($request['attendance_date'], $request['staff'][$value]);

        if ($attendance_id == 0) {

            $attendance_id = $this->add($request, $attendance_id, $value);
        } else {


            $this->handle_details($request, $updating_data, $attendance_id, $value);

            if ($request->post('attendance_final') == 'complete') {

                $this->sanction($attendance_id, $request, $value);
            }
        }
    }


    // public function add(...$list_data){

    //     $request = $list_data['request'];
    //     $value = $list_data['value'];

    //     $attendance = new Attendance();
    //     $attendance->staff_id =  $request['staff'][$value];
    //     $attendance->attendance_date = $request['attendance_date'][$value];
    //     $attendance->attendance_status = $request['attendance_status'][$value];
    //     $attendance->save();
    // }
}
