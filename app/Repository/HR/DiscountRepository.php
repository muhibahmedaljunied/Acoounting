<?php

namespace App\Repository\HR;
use App\Models\Discount;
use App\Models\Payroll;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use DB;

class DiscountRepository implements HRRepositoryInterface,PayrollRepositoryInterface
{


    function Sum($data)
    {

        foreach ($data as $sub) {

            $sub->sum_discount = 0;
            foreach ($sub->discount as $key => $value) {

                $sub->sum_discount += $value->quantity;
            }
        }
    }
    function add(...$list_data)
    {

        $attendance_id  = 0;
        $request = $list_data['request'];
        $value = $list_data['value'];

        $temporale = new Discount();
        $temporale->staff_id = $request['staff'][$value];
        $temporale->discount_type_id = $request['discount_type'][$value];
        $temporale->quantity = $request['qty'][$value];
        $temporale->date = $request['date'][$value];

        $temporale->save();
        return $temporale->id;
    }

    public function refresh($request, $value)
    {
        

        $payroll = DB::table('discounts')->where('staff_id', $request['staff'][$value])->sum('quantity');
        $data = ['total_discount' => $payroll];
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
