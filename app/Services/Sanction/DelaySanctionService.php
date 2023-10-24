<?php

namespace App\Services\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Models\DelaySanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class DelaySanctionService implements SanctionRepositoryInterface
{
    use SanctionTrait;

    // function update($request)
    // {


    //     $temporale_f = tap(DelaySanction::whereDelaySanction($request))
    //         ->update(['sanction' => $request['sanction']])
    //         ->get('id');

    //     return $temporale_f;
    // }

    // function add($request, $value)
    // {


    //     $temporale = new DelaySanction();
    //     $temporale->delay_type_id = $request['delay'][$value];
    //     $temporale->part_id = $request['delay_part'][$value];
    //     $temporale->iteration = $request['iteration'][$value];
    //     $temporale->sanction_discount_id = $request['discount_type'][$value];
    //     $temporale->discount = $request['discount'][$value];
    //     $temporale->sanction = $request['sanction'][$value];

    //     $temporale->save();
    //     return $temporale->id;
    // }

    // function get()
    // {

    //     $delay = DB::table('delay_sanctions')
    //         ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
    //         ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
    //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
    //         ->select('delay_sanctions.*', 'delay_sanctions.id as delay_sanction_id', 'parts.duration', 'delay_types.*', 'sanction_discounts.*')
    //         ->get();
    //     return $delay;
    // }

    function create($id, $request, $val)
    {


        $data  = $this->get();


        $day = date('l', strtotime($request['attendance_date']));
        $delay_current = $this->current_attendance($id);
        // $delay_current = 15;
        // return $delay_current;
        $iterat = $this->all_attendance($delay_current);
        // return $iterat;
        foreach ($data as $key => $value) {
            // return $value;
            if ($value->delay_type_id == 1 &&  $day == 'Saturday') {

                // return $request;
                if ($iterat == $value->iteration) {

                    $result = $this->sanction_finshed($id, $request, $val, $value, $type);
                    return $result;
                }
            }
        }
        // ----------------------------------------------------------------------------


    }
}
