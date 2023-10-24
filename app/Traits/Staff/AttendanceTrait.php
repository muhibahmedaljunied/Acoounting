<?php

namespace App\Traits\staff;

use App\Models\Attendance;
use App\Models\AttendanceDetail;


trait AttendanceTrait
{
    public function add_into_attendance_table()
    {

        $attendance = new Attendance();
        $attendance->staff_id =  $this->attendance_core->data['staff'][$this->attendance_core->value];
        $attendance->attendance_date = $this->attendance_core->data['attendance_date'];
        $attendance->attendance_final = $this->attendance_core->data['attendance_final'];
        $attendance->attendance_status = $this->attendance_core->data['attendance_status'];
        $attendance->save();

        $this->attendance_core->attendance_id = $attendance->id;
    }




    public function refresh_attendance_table()
    {


        // dd('wewe');

        $temporale_f = tap(attendance::where([

            'id' => $this->attendance_core->attendance_id,
        ]))
            ->update(['attendance_final' => $this->attendance_core->data['attendance_final']])
            ->first();

        // dd($temporale_f->id);
        $this->attendance_core->attendance_id = $temporale_f->id;
    }





    public function refresh_details_table($period_id, $data, $id)
    {


        $temporale_f = tap(AttendanceDetail::where([

            'attendance_id' => $id,
            'period_id' => $period_id
        ]))
            ->update($data)
            ->get('id');

        return $temporale_f;
    }


    public function get_from_attendance_table($date, $staff)
    {

        // dd('sd');
        $attendance = Attendance::where(['attendance_date' => $date, 'staff_id' => $staff])
            ->select('attendances.id')
            ->get();
        return $attendance;
    }

    public function init_details_table($data, $id, $value)
    {





        $Details = new AttendanceDetail();
        $Details->attendance_id = $id;
        $Details->period_id = $data['period'];
        $Details->attendance_status = $data['attendance_status'];


        if ($data['attendance_in_out'] == 1) {
            $Details->check_in = $data['time_in'][$value];
        } else {
            $Details->check_out = $data['time_out'][$value];

            $Details->duration = $data['duration'][$value];
            $Details->delay = $data['delay'][$value];
            $Details->leave = $data['leave'][$value];
            $Details->extra = $data['extra'][$value];
        }



        $Details->save();
    }
}
