<?php

namespace App\Repository\Sanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Traits\staff\Sanction\LeaveSanctionTrait;

use DB;

class LeaveRepository  implements SanctionRepositoryInterface, PayrollRepositoryInterface
{

    use SanctionTrait,LeaveSanctionTrait;
    // public function add($request, $value)
    // {
    //     $temporale = new LeaveSanction();
    //     $temporale->leave_type_id = $request['leave'][$value];
    //     $temporale->part_id = $request['leave_part'][$value];
    //     $temporale->iteration = $request['iteration'][$value];
    //     $temporale->sanction_discount_id = $request['discount_type'][$value];
    //     $temporale->discount = $request['discount'][$value];
    //     $temporale->sanction = $request['sanction'][$value];

    //     $temporale->save();
    //     return $temporale->id;
    // }

    // public function update($temporale, $request)
    // {

    //     $temporale_f = tap(LeaveSanction::whereLeaveSanction($request))
    //         ->update(['sanction' => $request['sanction']])
    //         ->get('id');
    //     return $temporale_f;
    // }

    public function create($attendance_id, $request, $val)
    {

        
    
        $data  = $this->get();
        $leave_current = $this->current_attendance($attendance_id, 'leave');

        $iterat = $this->all_attendance($leave_current, 'leave');
      
   
        foreach ($data as $key => $value) {


            if ($value->code == $request['type_leave_delay'] && $value->duration == $request['leave'][$val]) {

     
             
                if ($iterat == $value->iteration) {
               
                    $this->handle($request, $value->leave_sanction_id, $val, $attendance_id);
                }
            }

        }
    }

   

    public function handle($request, $leave_sanction_id, $val, $attendance_id)
    {


        $de = $this->get_sanction($leave_sanction_id,'LeaveSanction');
        $this->staff_sanction($request, $val, $attendance_id, $de);
        $this->refresh($request, $de);
    }
   
}
