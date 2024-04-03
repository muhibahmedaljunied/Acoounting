<?php

namespace App\Traits\staff;

use App\Models\Attendance;
use App\Models\AttendanceDetail;


trait AttendanceTrait
{




    function current_attendance()
    {

        return $attend = Attendance::where('id', $this->attendance_id)->with([
            'attendance_details' => function ($query) {
                $query->select('*');
            }

        ])
            ->paginate(10);

        // foreach ($attend as $key => $total) {

        //     $total->total_delay = 0;
        //     $total->total_leave = 0;
        //     $total->total_extra = 0;
        //     $total->total_extra_after = 0;
        //     $total->total_duration = 0;


        //     foreach ($total->attendance_details as $value_delay_sub) {


        //         $total->total_delay += $value_delay_sub->delay;
        //         $total->total_leave += $value_delay_sub->leave;
        //         $total->total_extra += $value_delay_sub->extra;
        //         $total->total_extra_after += $value_delay_sub->extra_after;
        //         $total->total_duration += $value_delay_sub->duration;

        //     }
        // }


        // if ($this->type == 'delay') {

        //     $this->duration = $total->total_delay;
        // }

        // if ($this->type == 'leave') {

        //     $this->duration = $total->total_leave;
        // }

        // if ($this->type == 'extra') {

        //     $this->duration = $total->total_extra+$total->total_extra_after;

        // }
    }
    function all_attendance()
    {

        // return $de;

        // $de = $this->sanction;


        // if ($this->table == 'LeaveSanction') {
        //     dd('18e2w',$this->sanction);
        // }

        // $count = 0;

        return $attend = Attendance::with([
            'attendance_details' => function ($query) {
                $query->select('*');
            }

        ])
            ->paginate(10);



        // foreach ($attend as $key => $total) {

        //     $total->total_delay = 0;
        //     $total->total_leave = 0;
        //     $total->total_extra = 0;
        //     $total->total_extra_after = 0;
        //     $total->total_duration = 0;



        //     foreach ($total->attendance_details as $value_delay_sub) {


        //         $total->total_delay += $value_delay_sub->delay;
        //         $total->total_leave += $value_delay_sub->leave;
        //         $total->total_extra += $value_delay_sub->extra;
        //         $total->total_extra_after = $value_delay_sub->extra_after;
        //         $total->total_duration += $value_delay_sub->duration;
        //     }


        //     // $this->calc_count($count);
        //     if ($this->type == 'delay' && $this->duration == $total->total_delay) {

        //         $count += 1;
        //     }

        //     if ($this->type == 'leave' && $this->duration == $total->total_leave) {


        //         $count += 1;
        //     }

        //     if ($this->type == 'extra' && $this->duration == $total->total_extra) {


        //         $count += 1;
        //     }

        //     if ($this->type == 'extra' && $this->duration == $total->total_extra_after) {


        //         $count += 1;
        //     }
        // }



      

        // $this->iterat = $count;



        // return $count;
    }

    public function add_into_attendance_table()
    {

        $attendance = new Attendance();
        $attendance->staff_id =  $this->data['staff'][$this->value];
        $attendance->attendance_date = $this->data['attendance_date'];
        $attendance->attendance_final = $this->data['attendance_final'];
        $attendance->attendance_status = $this->data['attendance_status'];
        $attendance->save();


        $this->attendance_id = $attendance->id;
    }




    public function refresh_attendance_table()
    {


        // dd($this->attendance_id);

        $temporale_f = collect(tap(attendance::where([

            'id' => $this->attendance_id,
        ]))
            ->update(['attendance_final' => $this->data['attendance_final']])
            ->get())->toArray();

        if (count($temporale_f) != 0) {

            $this->attendance_id = $temporale_f[0]['id'];
        }
    }





    public function refresh_details_table()
    {




        $temporale_f = collect(tap(AttendanceDetail::where([

            'attendance_id' => $this->attendance_id,
            'period_id' => $this->data['period']
        ]))
            ->update($this->updating_data)
            ->get('id'))->toArray();

        // dd(count($temporale_f));
        if (count($temporale_f) != 0) {

            // dd($temporale_f);
            $this->attendance_details_id = $temporale_f[0]['id'];
        }



        // dd($temporale_f);
        // return $temporale_f;
    }


    public function get_from_attendance_table()
    {





        $this->attendance_id =  Attendance::where([

            'attendance_date' => $this->data['attendance_date'],
            'staff_id' => $this->data['staff'][$this->value]
        ])
            ->select('attendances.id')
            ->get();
    }

    public function get_from_attendance_details_table()
    {



        $this->attendance_details_id =  AttendanceDetail::where([

            'attendance_id' => $this->attendance_id
        ])
            ->select('attendance_details.id')
            ->get();

        // dd('145',$this->attendance_details_id);
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
            $Details->extra_after = $data['extra_after'][$value];

        }



        $Details->save();
    }
}
