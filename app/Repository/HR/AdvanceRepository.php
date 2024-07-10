<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Advance;
use App\Services\PayrollService;
use DB;

class AdvanceRepository
{

    public function __construct(public CoreStaffService $core)
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

            $sub->sum_advanve = 0;
            foreach ($sub->advance as $key => $value) {

                $sub->sum_advanve += $value->quantity;
            }
        }
    }
    function store()
    {

        if ($this->core->temporale_f->isEmpty()) {
            $temporale = Advance::updateOrCreate(
                [
                    'staff_id' => $this->core->data['staff'][$this->core->value],
                    'quantity' => $this->core->data['qty'][$this->core->value],
                    'date' => $this->core->data['date'],

                ]
            );
            $this->core->id = $temporale->id;
        }
    }
  

    public function update()
    {
        $this->core->temporale_f = tap(Advance::whereAdvance($this->core->data))
            ->update(['quantity' => $this->core->data['qty'][$this->core->value]])
            ->get('id');
    }

    public function refresh()
    {


        $payroll = DB::table('advances')->where('staff_id', $this->core->data['staff'][$this->core->value])->sum('quantity');
        $data = ['total_advance' => $payroll];
   
        $this->core->data_of_hr_for_update_payroll = $data;
        // $this->payroll->payroll();

        // $payroll = tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
        //     ->update($data)
        //     ->get('id');
        // return $payroll;
    }
}
