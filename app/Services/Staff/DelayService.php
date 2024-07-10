<?php

namespace App\Services\Staff;
use App\Repository\StaffSaction\StaffDelaySanctionRepository;
use App\Traits\staff\Sanction\DelaySanctionTrait;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;

class DelayService
{

    use DelaySanctionTrait;

    public function __construct(

        protected StaffDelaySanctionRepository $details,
        protected CoreStaffService $core,

    ) {
    }


    public function create()
    {


        $this->get();  //this get delay_sanctions
     
        // -------------------------------------this calc from delay_table-----------------------------------------------------------
        $delay = DB::table('delays')->where('delay_type_id', $this->core->data['delay_type'][$this->core->value])->get();

  
        for ($i = 0; $i < count($this->core->data_sanction); $i++) {


            if ($this->core->data['delay_type'][$this->core->value] == $this->core->data_sanction[$i]->delay_type_id) {

                $this->handle($i, $delay);
                if ($i + 1 < count($this->core->data_sanction) && $this->core->status_sanction != true) {

                    $this->state_three($i,$delay);
                }
            }
        }


        return $this;
    }


    public function state_three($i, $delay)
    {


        // هذه في حاله مده الاضافي بين قيمتين
        if (
            ($this->core->data['delay_part'][$this->core->value]) > ($this->core->data_sanction[$i]->part_id) &&
            ($this->core->data['delay_part'][$this->core->value]) < ($this->core->data_sanction[$i + 1]->part_id)

        ) {

            $this->handle($i, $delay);
        }
    }


    public function handle($i, $delay)
    {


        // dd($this->core->data_sanction[$i]->iteration,count($delay));

        $this->show($this->core->data_sanction[$i]->sanction_id);  
        if ($this->core->data_sanction[$i]->iteration == 6) { //هذا في حاله كان الخيار اي مره

            $this->details->sanction();
        }
        if (count($delay) == $this->core->data_sanction[$i]->iteration) { //هذا في حاله كان الخيار عدد المرات

            $this->details->sanction();
        }
    }
}
