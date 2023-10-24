<?php

namespace App\Repository\HR;

use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\CoreStaffService;
use App\Models\Allowance;
use App\Models\Payroll;
use DB;

class AllowanceRepository implements HRRepositoryInterface, PayrollRepositoryInterface
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

        // dd($this->core->data);
        $temporale = new Allowance();
        $temporale->staff_id = $this->core->data['staff'][$this->core->value];
        $temporale->allowance_type_id = $this->core->data['allowance_type'][$this->core->value];
        // $temporale->date = $this->core->data['date'][$this->core->value];
        $temporale->qty = $this->core->data['qty'][$this->core->value];

        $temporale->save();
        return $temporale->id;
    }

    public function update()
    {
        $temporale_f = tap(Allowance::whereAllowance($this->core->data))
            ->update(['qty' => $this->core->data['qty'][$this->core->value]])
            ->get('id');
        return $temporale_f;
    }

    public function refresh($request, $value)
    {


        $payroll = DB::table('allowances')->where('staff_id', $this->core->data['staff'][$this->core->value])->sum('qty');
        $data = ['total_allowance' => $payroll];
        $payroll = tap(Payroll::where(['staff_id' => $this->core->data['staff'][$this->core->value]]))
            ->update($data)
            ->get('id');

        return $payroll;
    }
}
