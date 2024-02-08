<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\ExtraSanction;
class ExtraSanctionRepository
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


        if ($this->core->temporale_f->isEmpty()) {

            $temporale = ExtraSanction::updateOrCreate(
                [
                    'extra_type_id' => $this->core->data['extra'][$this->core->value],
                    'part_id' => $this->core->data['extra_part'][$this->core->value],
                    'sanction_discount_id' => $this->core->data['discount_type'][$this->core->value],
                    'iteration' => $this->core->data['iteration'][$this->core->value],
                    'sanction' => $this->core->data['sanction'][$this->core->value]


                ]
            );
            $this->core->id = $temporale->id;
        }
        // return $temporale_f;
    }


    public function update()
    {

        $this->core->temporale_f = tap(ExtraSanction::whereExtraSanction($this->core->data))
            ->update(['sanction' => $this->core->data['sanction'][$this->core->value]])
            ->get('id');
    }

   
}
