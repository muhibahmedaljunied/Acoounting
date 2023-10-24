<?php

namespace App\Services\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Models\ExtraSanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class ExtraSanctionService implements SanctionRepositoryInterface
{
    use SanctionTrait;

    // function update($temporale, $request)
    // {


    //     $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
    //         ->update(['sanction' => $request['sanction']])
    //         ->get('id');


    //     return $temporale_f;
    // }
    // function add($request, $value)
    // {
    //     $temporale = new ExtraSanction();
    //     $temporale->extra_type_id = $request['extra'][$value];
    //     $temporale->part_id = $request['extra_part'][$value];
    //     $temporale->iteration = $request['iteration'][$value];
    //     $temporale->sanction_discount_id = $request['discount_type'][$value];
    //     $temporale->sanction = $request['sanction'][$value];
    //     $temporale->save();
    //     return $temporale->id;
    // }

    // function get()
    // {


    //     $extra = DB::table('extra_sanctions')
    //         ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
    //         ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
    //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
    //         ->select('extra_sanctions.*', 'extra_sanctions.id as extra_sanction_id', 'parts.duration', 'extra_types.*', 'sanction_discounts.*')
    //         ->get();
    //     return $extra;
    // }

    function create($id, $request, $val)
    {


        $data  = $this->get();


        $day = date('l', strtotime($request['attendance_date']));
        $extra_current = $this->current_attendance($id);
        // $leave_current = 15;

        // return $leave_current;
        $iterat = $this->all_attendance($extra_current);
        // return $iterat;
        foreach ($data as $key => $value) {

            // return $type;

            if ($value->extra_type_id == 1 &&  $day == 'Saturday') {

                if ($iterat == $value->iteration) {

                    $result = $this->sanction_finshed($id, $request, $val, $value, $type);
                    
                    return $result;
                }
            }
        }
    }
}
