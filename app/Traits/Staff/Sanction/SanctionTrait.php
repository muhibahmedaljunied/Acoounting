<?php

namespace App\Traits\staff\Sanction;

use App\Models\Attendance;
use App\Models\StaffSanction;
use App\Models\Payroll;
use DB;

trait SanctionTrait
{


    function current_attendance($id, $type)
    {

        $attend = Attendance::where('id', $id)->with([
            'attendance_details' => function ($query) {
                $query->select('*');
            }

        ])
            ->paginate(10);


        foreach ($attend as $key => $total) {

            $total->total_delay = 0;
            $total->total_leave = 0;
            $total->total_duration = 0;

            foreach ($total->attendance_details as $value_delay_sub) {


                $total->total_delay += $value_delay_sub->delay;
                $total->total_leave += $value_delay_sub->leave;
                $total->total_duration += $value_delay_sub->duration;
            }
        }

        if ($type == 'delay') {
            return $total->total_delay;
        }

        if ($type == 'leave') {
            return $total->total_leave;
        }
    }
    function all_attendance($de, $type)
    {

        // return $de;
        $count = 0;

        $attend = Attendance::with([
            'attendance_details' => function ($query) {
                $query->select('*');
            }

        ])
            ->paginate(10);


        foreach ($attend as $key => $total) {

            $total->total_delay = 0;
            $total->total_leave = 0;
            $total->total_duration = 0;

            foreach ($total->attendance_details as $value_delay_sub) {


                $total->total_delay += $value_delay_sub->delay;
                $total->total_leave += $value_delay_sub->leave;
                $total->total_duration += $value_delay_sub->duration;
            }



            if ($type == 'delay') {

                if ($de == $total->total_delay) {
                    $count += 1;
                }
            }

            if ($type == 'leave') {

                if ($de == $total->total_leave) {
                    $count += 1;
                }
            }
        }




        return $count;
    }




    public function staff_sanction($request, $value, $attendance_id, $de)
    {
    
        // $staff_sanction = $this->get_staff_sanction($request,$attendance_id,$value);
      
        // if ($staff_sanction == 0) {

            $this->add_staff_sanction($request, $value, $attendance_id, $de);
        // } else {

        //     $this->update_staff_sanction($request, $value, $attendance_id, $de);
        // }
    }

    public function update_staff_sanction($request, $value, $id, $de)
    {


        $temporale = new StaffSanction();
        $temporale->staff_id = $request['staff'][$value];
        $temporale->attendance_id = $id;
        $temporale->date = $request['attendance_date'];
        $temporale->sanctionable()->associate($de);
        $temporale->save();
        return 1;
    }

    public function add_staff_sanction($request, $value, $id, $de)
    {


        $temporale = new StaffSanction();
        $temporale->staff_id = $request['staff'][$value];
        $temporale->attendance_id = $id;
        $temporale->date = $request['attendance_date'];
        $temporale->sanctionable()->associate($de);
        $temporale->save();
            
        return 1;
    }

    public function get_staff_sanction($request,$attendance_id,$value)
    {

       
        $id = StaffSanction::where([
            'staff_id' => $request['staff'][$value],
            'attendance_id' => $attendance_id
        ])
            ->select('staff_sanctions.id')
            ->get();

        if ($id->isEmpty()) {

            return $id = 0;
        } else {


            foreach ($id as $values) {
                $id = $values['id'];
            }

            return $id;
        }
    }

    public function get_sanction($id, $table)
    {


        $model_prefix = "App\Models";
        $model = $model_prefix . '\\' . $table;
        $de = $model::find($id);
  

        return $de;
    }
    public function refresh($request,$data,$total='total_sanction')
    {
      
        tap(Payroll::where('staff_id', $request['staff'][0]))->increment($total, $data->sanction)->get();
    }
}
