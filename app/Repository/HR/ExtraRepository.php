<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Extra;

class ExtraRepository
{
    
    public $staff_id;
    public $extra_type_id;
    public $part_id;
    public $date;
    public $number_hours;
    public $start_time;
    public $end_time;

    public function __construct(public CoreStaffService $core)
    {


        
    }

    // public function handle()
    // {
    //     // dd($this->core->data);
    //     // $this->update();
    //     $this->store();
    // }
    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_number_hours = 0;
            foreach ($sub->extra as $key => $value) {

                $sub->sum_number_hours += $value->number_hours;
            }
        }
    }
 

    function store()
    {
        // if (empty($this->core->temporale_f)) {

            // dd($this->core->data['duration'][$this->core->value][0]);
        $temporale = Extra::updateOrCreate(
            [
                // 'staff_id' => $this->core->data['staff'][$this->core->value],
                // 'extra_type_id' => $this->core->data['extra_type'][$this->core->value],
                // 'date' => $this->core->data['date'][$this->core->value],
                // 'start_time' => $this->core->data['start_time'][$this->core->value],
                // 'end_time' => $this->core->data['end_time'][$this->core->value],
                // 'number_hours' => $this->core->data['duration'][$this->core->value][0],


                'staff_id' => $this->staff_id,
                'extra_type_id' => $this->extra_type_id ,
                'date' => $this->date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'number_hours' => $this->number_hours,




            ]
        );
        $this->core->id = $temporale->id;
    // }

    }
    // public function update()
    // {

   
   
    //     $this->core->temporale_f= tap(Extra::whereExtra($this->core))
    //         ->update([
    //             'number_hours' => $this->core->data['duration'][$this->core->value]
    //         ])
    //         ->get('id');
         
    // }

   
    // public function refresh($id,$value)
    // {
        
    //     // dd($value->sanction);
    //   tap(Payroll::where('staff_id',$id))->increment('total_extra',$value->sanction)->get(); 

    // }
}
