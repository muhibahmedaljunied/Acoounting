<?php

namespace App\Repository\HR;

use App\Models\Advance;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\AttendanceRepositoryInterface;
use App\RepositoryInterface\HRRepositoryInterface;
use DB;

class AbsenceRepository implements AttendanceRepositoryInterface
{

    public function handle($request, $value)
    {


        $attendance_id = $this->get($request['attendance_date'], $request['staff'][$value]);

        if ($attendance_id == 0) {

            $attendance_id = $this->create($request, $value);
            $this->sanction($attendance_id, $request, $value);
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
