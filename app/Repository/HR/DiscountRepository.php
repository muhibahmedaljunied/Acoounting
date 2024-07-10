<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Discount;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;

class DiscountRepository
{

    public function __construct(public CoreStaffService $core,public PayrollService $payroll)
    {


        
    }

    public function handle()
    {

        $this->update();
        $this->store();
        $this->refresh();
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
    function store()
    {

        if ($this->core->temporale_f->isEmpty()) {


        $temporale = Discount::updateOrCreate(
            [
                'staff_id' => $this->core->data['staff'][$this->core->value],
                'discount_type_id' => $this->core->data['discount_type'][$this->core->value],
                'quantity' => $this->core->data['qty'][$this->core->value],
                'date' => $this->core->data['date'][$this->core->value]

            ]
        ); 
        $this->core->id = $temporale->id;
        }
    }

    public function update()
    {

        $this->core->temporale_f = tap(Discount::whereDiscount($this->core->data))
        ->update(['quantity' => $this->core->data['qty'][$this->core->value]])
        ->get('id');

    }

    public function refresh()
    {
        

        $payroll = DB::table('discounts')->where('staff_id', $this->core->data['staff'][$this->core->value])->sum('quantity');
        $data = ['total_discount' => $payroll];
        $this->core->data_of_hr_for_update_payroll = $data;

        // $payroll = tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
        // ->update($data)
        // ->get('id');

     
        // return $payroll;

    }
 
}
