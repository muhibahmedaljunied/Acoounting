<?php

namespace App\Repository\HR;

use App\Models\Extra;
use App\Models\ExtraDetail;
use App\Models\Payroll;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use DB;

class ExtraRepository implements HRRepositoryInterface, DetailRepositoryInterface, PayrollRepositoryInterface
{


    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_number_hours = 0;
            foreach ($sub->extra as $key => $value) {

                $sub->sum_number_hours += $value->number_hours;
            }
        }
    }
    function add(...$list_data)
    {

        $attendance_id  = 0;
        $request = $list_data['request'];
        $value = $list_data['value'];

        $temporale = new Extra();
        $temporale->staff_id = $request['staff'][$value];
        $temporale->extra_type_id = $request['extra_type'][$value];
        $temporale->date = $request['date'][$value];
        $temporale->start_time = $request['start_time'][$value];
        $temporale->end_time = $request['end_time'][$value];
        $temporale->number_hours = $request['duration'][$value][0];

        $temporale->save();
        return $temporale->id;
    }

    public function update($request, $value = null)
    {
        $temporale_f = tap(Extra::whereExtra($request))
            ->update([
                'date' => $request['date'][$value],
                'start_time' => $request['start_time'][$value],
                'end_time' => $request['end_time'][$value],
                'number_hours' => $request['duration'][$value]
            ])
            ->get('id');

        return $temporale_f;
    }

    public function init_details(...$list_data)
    {


        $data = $list_data['request'];
        $id = $list_data['id'];
        $value = $list_data['value'];
        $temporale = new ExtraDetail();
        $temporale->extra_id = $id;
        $temporale->extra_sanction_id = $value->extra_sanction_id;
        $temporale->date = $data['date'][1];
        $temporale->save();
    }
    public function refresh($id, $value)
    {
        
      tap(Payroll::where('staff_id',$id))->increment('total_extra',$value->sanction)->get();

       

    }
}
