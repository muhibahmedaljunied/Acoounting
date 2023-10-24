<?php

namespace App\Repository\HR;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\CoreStaffService;
use App\Models\Discount;
use App\Models\Payroll;
use DB;

class DiscountRepository implements HRRepositoryInterface,PayrollRepositoryInterface
{

    public function __construct(public CoreStaffService $core)
    {


        
    }

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

     

        $temporale = new Discount();
        $temporale->staff_id = $this->core->data['staff'][$this->core->value];
        $temporale->discount_type_id = $this->core->data['discount_type'][$this->core->value];
        $temporale->quantity = $this->core->data['qty'][$this->core->value];
        $temporale->date = $this->core->data['date'][$this->core->value];
        $temporale->save();
        $this->core->id = $temporale->id;
    }

    public function update()
    {

        $temporale_f = tap(Discount::whereDiscount($this->core->data))
        ->update(['quantity' => $this->core->data['qty'][$this->core->value]])
        ->get('id');

        return $temporale_f;
    }

    public function refresh($request, $value)
    {
        

        $payroll = DB::table('discounts')->where('staff_id', $this->core->data['staff'][$this->core->value])->sum('quantity');
        $data = ['total_discount' => $payroll];
        $payroll = tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
        ->update($data)
        ->get('id');

        // return $payroll;

    }
 
}
