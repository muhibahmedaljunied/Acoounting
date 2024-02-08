<?php

namespace App\Repository\HR;
use App\Services\CoreStaffService;
use App\Models\Vacation;
class VacationRepository
{
    // public $core;
    public function __construct(public CoreStaffService $core)
    {

        // $this->core = app(CoreStaffService::class);

    }
    public function handle()
    {

        $this->update();
        $this->store();
    }
    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_vacation = 0;
            foreach ($sub->vacation as $key => $value) {

                $sub->sum_vacation += $value->total_days;
            }
        }
    }
    function store()
    {

        if ($this->core->temporale_f->isEmpty()) {

            $temporale = Vacation::updateOrCreate(
                [
                    'staff_id' => $this->core->data['staff'][$this->core->value],
                    'vacation_type_id' => $this->core->data['leave_type'][$this->core->value],
                    'start_date' => $this->core->data['start_date'][$this->core->value],
                    'end_date' => $this->core->data['end_date'][$this->core->value],
                    'total_days' => $this->core->data['days'][$this->core->value],


                ]
            );
            $this->core->id = $temporale->id;
        }
    }

    public function update()
    {

        $this->core->temporale_f  = tap(Vacation::whereLeave($this->core->data))
            ->update(['total_days' => $this->core->data['days'][$this->core->value]])
            ->get('id');
    }
}
