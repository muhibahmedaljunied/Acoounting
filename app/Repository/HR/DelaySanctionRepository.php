<?php

namespace App\Repository\HR;

use App\Services\CoreStaffService;
use App\Models\DelaySanction;

class DelaySanctionRepository
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



            // dd($this->core->data['sanction'][$this->core->value]);
            $temporale = DelaySanction::updateOrCreate(
                [
                    'delay_type_id' => $this->core->data['delay'][$this->core->value],
                    'part_id' => $this->core->data['delay_part'][$this->core->value],
                    'sanction_discount_id' => $this->core->data['discount_type'][$this->core->value],
                    'discount' => $this->core->data['discount'][$this->core->value],
                    'iteration' => $this->core->data['iteration'][$this->core->value],
                    'sanction' => $this->core->data['sanction'][$this->core->value]


                ]
            );
            $this->core->id = $temporale->id;
        }
    }


    public function update()
    {

       
        $this->core->temporale_f = collect(tap(DelaySanction::whereDelaySanction($this->core->data,$this->core->value))
            ->update(['sanction' => $this->core->data['sanction'][$this->core->value]])
            ->get('id'))
            ->toArray();
    }

 
}
