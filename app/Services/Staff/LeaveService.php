<?php

namespace App\Services\Staff;
use App\Repository\StaffSaction\StaffLeaveSanctionRepository;
use App\Traits\staff\Sanction\LeaveSanctionTrait;
use App\Services\CoreStaffService;
use App\Services\Core\SanctionService;
use Illuminate\Support\Facades\DB;

class LeaveService extends SanctionService
{

    use LeaveSanctionTrait;

    public function __construct(

        protected StaffLeaveSanctionRepository $details,
        protected CoreStaffService $core,

    ) {
    }


    public function create()
    {



        $this->get();  //this get leave_sanctions
        // dd($this->core->data_sanction);
        // -------------------------------------this calc from leave_table-----------------------------------------------------------
        $leave = DB::table('leaves')->where('leave_type_id', $this->core->data['leave_type'][$this->core->value])->get();

        for ($i = 0; $i < count($this->core->data_sanction); $i++) {

            //this check if type of leave equal type of sanction

            if ($this->core->data['leave_type'][$this->core->value] == $this->core->data_sanction[$i]->leave_type_id) {

             
                $this->handle($i, $leave);

                if ($i + 1 < count($this->core->data_sanction) && $this->core->status_sanction != true) {

                    $this->state_three($i, $leave);
                }
            }
        }


        return $this;
    }



    public function state_three($i, $leave)
    {


        // هذه في حاله مده الاضافي بين قيمتين
        if (
            ($this->core->data['leave_part'][$this->core->value]) > ($this->core->data_sanction[$i]->part_id) &&
            ($this->core->data['leave_part'][$this->core->value]) < ($this->core->data_sanction[$i + 1]->part_id)

        ) {

            $this->handle($i, $leave);
        }
    }


    public function handle($i, $leave)
    {



        $this->show($this->core->data_sanction[$i]->sanction_id);

        if ($this->core->data_sanction[$i]->iteration == 6) { //هذا في حاله كان الخيار اي مره

            $this->details->sanction();


        }
        if (count($leave) == $this->core->data_sanction[$i]->iteration) { //هذا في حاله كان الخيار عدد المرات

            $this->details->sanction();

        }
    }
}
