<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Delay;

class DelayRepository 
{
    public $staff_id;
    public $delay_type_id;
    public $part_id;
    public $date;
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
                'staff_id' => $this->staff_id,
                'delay_type_id' => $this->delay_type_id,
                'part_id' => $this->part_id,
                'date' => $this->date

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
