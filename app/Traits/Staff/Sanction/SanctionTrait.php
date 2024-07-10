<?php

namespace App\Traits\staff\Sanction;

use App\Models\Attendance;
use App\Models\StaffSanction;
use App\Models\Payroll;
use DB;

trait SanctionTrait
{

    public function staff_sanction()
    {

        // $staff_sanction = $this->get_staff_sanction($request,$attendance_id,$value);

        // dd('yes',$this->sanction);
        if ($this->sanction != null) {


        $this->add_staff_sanction();
        }
        // else {

        //     $this->update_staff_sanction($request, $value, $attendance_id, $de);
        // }
    }

    public function update_staff_sanction()
    {


        $temporale = new StaffSanction();
        $temporale->staff_id = $this->data['staff'][$this->value];
        // $temporale->attendance_id = $this->attendance_id;
        $temporale->date = $this->data['attendance_date'];
        $temporale->sanctionable()->associate($this->sanction);
        $temporale->save();
        return 1;
    }

    public function add_staff_sanction()
    {


   
        $temporale = new StaffSanction();
        $temporale->staff_id = $this->data['staff'][$this->value];
        // $temporale->attendance_id = $this->attendance_id;
        $temporale->date = $this->data['attendance_date'];
        $temporale->sanctionable()->associate($this->sanction);
        $temporale->save();

        // dd('qwe',$temporale->id);

    }

    public function get_staff_sanction()
    {


        $id = StaffSanction::where([
            'staff_id' => $this->data['staff'][$this->value],
            // 'attendance_id' => $this->attendance_id
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

    public function get_sanction()
    {

        $model = "App\Models" . '\\' . $this->table;
        $this->sanction = $model::find($this->sanction_type_id);

        // if ($this->table == 'LeaveSanction') {
        //     dd('asw23',$this->sanction);
        // }
        
   
    }
    public function payroll($total = 'total_sanction')
    {

        if ($this->sanction != null) {


            tap(Payroll::where('staff_id', $this->data['staff'][0]))
            ->increment($total, $this->sanction->sanction)
            ->get();
      
        }

     
    }
}
