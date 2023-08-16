<?php

namespace App\Repository\HR;

use App\Models\Advance;
use App\Models\Payroll;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use DB;

class AdvanceRepository implements HRRepositoryInterface,PayrollRepositoryInterface
{

    function Sum($data)
    {

        foreach ($data as $sub) {

            $sub->sum_advanve = 0;
            foreach ($sub->advance as $key => $value) {

                $sub->sum_advanve += $value->quantity;
            }
        }
    }
    function add(...$list_data)
    {

        $attendance_id  = 0;
        $request = $list_data['request'];
        $value = $list_data['value'];
    
        $temporale = new Advance();
        $temporale->staff_id = $request['staff'][$value];
        // $temporale->extra_type_id = $request->post('extra_type')[$value];
        $temporale->date = $request['date'][$value];
        $temporale->quantity = $request['qty'][$value];
             
        $temporale->save();
        return $temporale->id;
    }
    public function refresh($request, $value)
    {
        

        $payroll = DB::table('advances')->where('staff_id', $request['staff'][$value])->sum('quantity');
        $data = ['total_advance' => $payroll];

        $payroll = tap(Payroll::where(['staff_id' => $request['staff'][$value]]))
        ->update($data)
        ->get('id');

        return $payroll;
    }

    public function update($request,$value=null)
    {
        $temporale_f = tap(Advance::whereAdvance($request))
        ->update(['quantity' => $request['qty'][$value]])
        ->get('id');

        return $temporale_f;
    }
}
