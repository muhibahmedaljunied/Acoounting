<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Absence;
class AbsenceRepository 
{
    
    public function __construct(public CoreStaffService $core)
    {


        
    }

    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_number_hours = 0;
            foreach ($sub->absence as $key => $value) {

                $sub->sum_number_hours += $value->number_hours;
            }
        }
    }
    function store()
    {

      
        $temporale = Absence::updateOrCreate(
            [
                'staff_id' => $this->core->data['staff'][$this->core->value],
                'absence_type_id' => $this->core->data['absence_type'][$this->core->value],
                'date' => $this->core->data['date'][$this->core->value],

            ]
        );
        $this->core->id = $temporale->id;

    }

   


    // public function refresh($id,$value)
    // {
        
    //     // dd($value->sanction);
    //   tap(Payroll::where('staff_id',$id))->increment('total_absence',$value->sanction)->get(); 

    // }
}
