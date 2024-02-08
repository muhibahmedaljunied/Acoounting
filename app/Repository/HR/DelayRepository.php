<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Delay;

class DelayRepository 
{
    
    public function __construct(public CoreStaffService $core)
    {


        
    }

    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_number_hours = 0;
            foreach ($sub->delay as $key => $value) {

                $sub->sum_number_hours += $value->number_hours;
            }
        }
    }
    function store()
    {

    //   dd($this->core->data['delay_part'][$this->core->value]);
        $temporale = Delay::updateOrCreate(
            [
                'staff_id' => $this->core->data['staff'][$this->core->value],
                'delay_type_id' => $this->core->data['delay_type'][$this->core->value],
                'part_id' => $this->core->data['delay_part'][$this->core->value],
                'date' => $this->core->data['date'][$this->core->value]

            ]
        ); 
        $this->core->id = $temporale->id;

   
     
    }

   
    // public function refresh($id,$value)
    // {
        
    //     // dd($value->sanction);
    //   tap(Payroll::where('staff_id',$id))->increment('total_delay',$value->sanction)->get(); 

    // }
}
