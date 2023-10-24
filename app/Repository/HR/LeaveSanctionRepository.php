<?php

namespace App\Repository\HR;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\CoreStaffService;
use App\Models\LeaveSanction;
use DB;

class LeaveSanctionRepository implements HRRepositoryInterface
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

    
    
        $temporale = new LeaveSanction();
        $temporale->leave_type_id = $this->core->data['leave'][$this->core->value];
        $temporale->part_id = $this->core->data['leave_part'][$this->core->value];
        $temporale->sanction_discount_id = $this->core->data['discount_type'][$this->core->value];
        $temporale->discount = $this->core->data['discount'][$this->core->value];
        $temporale->iteration = $this->core->data['iteration'][$this->core->value];
        $temporale->sanction = $this->core->data['sanction'][$this->core->value];
        $temporale->save();
        $this->core->id = $temporale->id;
    }
  

    public function update()
    {
        $temporale_f = tap(LeaveSanction::whereLeaveSanction($this->core->data))
        ->update(['sanction' => $this->core->data['sanction'][$this->core->value]])
        ->get('id');

        return $temporale_f;
    }
}
