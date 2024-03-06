<?php

namespace App\Repository\StaffSaction;
use App\Services\CoreStaffService;
use App\Models\StaffSanction;

class StaffAbsenceSanctionRepository
{

    public function __construct(public CoreStaffService $core)
    {
    }

    public function sanction()
    {


        
        $absence = new StaffSanction();
        $absence->staff_id = $this->core->data['staff'][$this->core->value];
        $absence->sanctionable()->associate($this->core->specific_sanction);
        $absence->date = $this->core->data['date'][$this->core->value];
        $absence->save();

        
    }

    public function update_sanction()
    {


        
        // dd($this->core->data['status']);
         tap(StaffSanction::where([
            'staff_id' => $this->core->data['staff'],
            'sanctionable_id' => $this->core->data['sanctionable_id'],
            'sanctionable_type' => $this->core->data['sanctionable_type'],
            'date' => $this->core->data['date']


        ]))
            ->update(['status' => $this->core->data['status']])
            ->get('id');

       


        
    }

   
}
