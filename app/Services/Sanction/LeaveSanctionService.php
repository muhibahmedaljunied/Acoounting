<?php

namespace App\Services\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Models\LeaveSanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class LeaveSanctionService implements SanctionRepositoryInterface
{
    use SanctionTrait;



    // function update($temporale, $request)
    // {

    //     $temporale_f = tap(LeaveSanction::whereLeaveSanction($request))
    //         ->update(['sanction' => $request['sanction']])
    //         ->get('id');


    //     return $temporale_f;
    // }
    // function add($request, $value)
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

    // function get()
    // {


    //     $leave = DB::table('leave_sanctions')
    //         ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
    //         ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
    //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
    //         ->select('leave_sanctions.*', 'leave_sanctions.id as leave_sanction_id', 'parts.duration', 'leave_types.*', 'sanction_discounts.*')
    //         ->get();
    //     return $leave;
    // }

    function create($id, $request, $val)
    {


        $data  = $this->get();

        $day = date('l', strtotime($request['attendance_date']));
        $leave_current = $this->current_attendance($id);
        // $leave_current = 15;

        // return $leave_current;
        $iterat = $this->all_attendance($leave_current);
        // return $iterat;
        foreach ($data as $key => $value) {

            // return $type;

            if ($value->leave_type_id == 1 &&  $day == 'Saturday') {

                if ($iterat == $value->iteration) {

                    $result = $this->sanction_finshed($id, $request, $val, $value, $type);
                    return $result;
                }
            }
        }
    }
}
