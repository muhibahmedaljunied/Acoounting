<?php

namespace App\Repository\HR;
use App\Models\Vacation;
use App\RepositoryInterface\HRRepositoryInterface;
use DB;

class VacationRepository implements HRRepositoryInterface
{

    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_vacation = 0;
            foreach ($sub->vacation as $key => $value) {

                $sub->sum_vacation += $value->total_days;
            }
        }
    }
    function add(...$list_data)
    {

        $attendance_id  = 0;
        $request = $list_data['request'];
        $value = $list_data['value'];


      
        $temporale = new Vacation();
        $temporale->staff_id = $request['staff'][$value];
        $temporale->vacation_type_id = $request['leave_type'][$value];
        $temporale->start_date = $request['start_date'][$value];
        $temporale->end_date = $request['end_date'][$value];
        $temporale->total_days = $request['days'][$value];

        $temporale->save();
        return $temporale->id;
    }

    public function update($request,$value=null)
    {
        $temporale_f = tap(Advance::whereAdvance($request))
        ->update(['quantity' => $request['qty'][$value]])
        ->get('id');

        return $temporale_f;
    }
}
