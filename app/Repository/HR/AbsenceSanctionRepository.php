<?php

namespace App\Repository\HR;

use App\Services\CoreStaffService;
use App\Models\AbsenceSanction;
use App\Models\StaffSanction;

class AbsenceSanctionRepository
{

    public function __construct(public CoreStaffService $core)
    {
    }

    public function handle()
    {

        $this->update();
        $this->store();
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

        if (empty($this->core->temporale_f)) {

            $temporale = AbsenceSanction::updateOrCreate(
                [
                    'absence_type_id' => $this->core->data['absence'][$this->core->value],
                    'sanction_discount_id' => $this->core->data['discount_type'][$this->core->value],
                    'discount' => $this->core->data['discount'][$this->core->value],
                    'iteration' => $this->core->data['iteration'][$this->core->value],
                    'sanction' => $this->core->data['sanction'][$this->core->value],

                ]
            );
            $this->core->id = $temporale->id;
        }
    }

    public function update()
    {
        $this->core->temporale_f = collect(tap(AbsenceSanction::whereAbsenceSanction($this->core->data,$this->core->value))
            ->update(['sanction' => $this->core->data['sanction'][$this->core->value]])
            ->get('id'))
            ->toArray();
    }
    // public function sanction()
    // {


        
    //     $absence = new StaffSanction();
    //     $absence->staff_id = $this->core->data['staff'][$this->core->value];
    //     $absence->sanctionable()->associate($this->core->specific_sanction);
    //     $absence->date = $this->core->data['date'][$this->core->value];
    //     $absence->save();

        
    // }

   
}
