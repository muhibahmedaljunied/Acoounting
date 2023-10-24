<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Models\Extra;
use App\Models\ExtraDetail;
use App\Models\Payroll;
use DB;

class ExtraRepository implements HRRepositoryInterface, DetailRepositoryInterface, PayrollRepositoryInterface
{
    
    public function __construct(public CoreStaffService $core)
    {


        
    }

    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_number_hours = 0;
            foreach ($sub->extra as $key => $value) {

                $sub->sum_number_hours += $value->number_hours;
            }
        }
    }
    function add()
    {

      
     
        $temporale = new Extra();
        $temporale->staff_id = $this->core->data['staff'][$this->core->value];
        $temporale->extra_type_id = $this->core->data['extra_type'][$this->core->value];
        $temporale->date = $this->core->data['date'][$this->core->value];
        $temporale->start_time = $this->core->data['start_time'][$this->core->value];
        $temporale->end_time = $this->core->data['end_time'][$this->core->value];
        $temporale->number_hours = $this->core->data['duration'][$this->core->value][0];
        $temporale->save();
        $this->core->id = $temporale->id;
     
    }

    public function update()
    {

   
   
        $temporale_f = tap(Extra::whereExtra($this->core->data))
            ->update([
                'date' => $this->core->data['date'][$this->core->value],
                'start_time' => $this->core->data['start_time'][$this->core->value],
                'end_time' => $this->core->data['end_time'][$this->core->value],
                'number_hours' => $this->core->data['duration'][$this->core->value]
            ])
            ->get('id');
         
        return $temporale_f;
    }

    public function init_details(...$list_data)
    {


       
        $value = $list_data['value'];
        $extra = new ExtraDetail();
        $extra->extra_id = $this->core->id;
        $extra->extra_sanction_id = $value->extra_sanction_id;
        $extra->save();

        $this->core->status_sanction = true;
        
    }

    public function refresh($id,$value)
    {
        
        // dd($value->sanction);
      tap(Payroll::where('staff_id',$id))->increment('total_extra',$value->sanction)->get(); 

    }
}
