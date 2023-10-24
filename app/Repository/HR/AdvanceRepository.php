<?php

namespace App\Repository\HR;

use App\Models\Advance;
use App\Models\Payroll;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\CoreStaffService;
use DB;

class AdvanceRepository implements HRRepositoryInterface,PayrollRepositoryInterface
{

    public function __construct(public CoreStaffService $core)
    {


        
    }

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

    
    
        $temporale = new Advance();
        $temporale->staff_id = $this->core->data['staff'][$this->core->value];
        // $temporale->extra_type_id = $request->post('extra_type')[$value];
        $temporale->date = $this->core->data['date'][$this->core->value];
        $temporale->quantity = $this->core->data['qty'][$this->core->value];
             
        $temporale->save();
        $this->core->id = $temporale->id;
    }
    public function refresh($request, $value)
    {
        

        $payroll = DB::table('advances')->where('staff_id', $this->core->data['staff'][$this->core->value])->sum('quantity');
        $data = ['total_advance' => $payroll];

        $payroll = tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
        ->update($data)
        ->get('id');

        return $payroll;
    }

    public function update()
    {
        $temporale_f = tap(Advance::whereAdvance($this->core->data))
        ->update(['quantity' => $this->core->data['qty'][$this->core->value]])
        ->get('id');

        return $temporale_f;
    }
}
