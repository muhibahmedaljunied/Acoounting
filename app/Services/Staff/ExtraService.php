<?php

namespace App\Services\Staff;
use App\Repository\StaffSaction\StaffExtraSanctionRepository;
use App\Traits\staff\Sanction\ExtraSanctionTrait;
use App\Services\CoreStaffService;
use App\Services\Core\SanctionService;
use Illuminate\Support\Facades\DB;

class ExtraService extends SanctionService
{

    use ExtraSanctionTrait;

    public function __construct(

        protected StaffExtraSanctionRepository $details,
        protected CoreStaffService $core,

    ) {
    }


    public function create()
    {

        $this->get();  //this get extra_sanctions
        // -------------------------------------this calc from extra_table-----------------------------------------------------------
        $extra = DB::table('extras')->where('number_hours', $this->core->data['duration'][$this->core->value][0])->get();

        for ($i = 0; $i < count($this->core->data_sanction); $i++) {

            //this check if type of extra equal type of sanction
            if ($this->core->data['extra_type'][$this->core->value] == $this->core->data_sanction[$i]->extra_type_id) {

                // $this->check_type($i, $data, $extra);
                $this->state_tow($i, $extra);
                if ($i + 1 < count($this->core->data_sanction) && $this->core->status_sanction != true) {

                    $this->state_three($i,$extra);
                }

            }
        }


        return $this;
    }


    public function state_tow($i,$extra)
    {

        if ($this->core->data['duration'][$this->core->value][0] == $this->core->data_sanction[$i]->duration) {

            $this->handle($i, $extra);
        }

    }

    public function state_three($i, $extra)
    {


        // هذه في حاله مده الاضافي بين قيمتين
        if (
            ($this->core->data['duration'][$this->core->value][0]) > ($this->core->data_sanction[$i]->duration) &&
            ($this->core->data['duration'][$this->core->value][0]) < ($this->core->data_sanction[$i + 1]->duration)

        ) {

            $this->handle($i, $extra);
        }
    }


    public function handle($i, $extra)
    {



        $this->show($this->core->data_sanction[$i]->sanction_id);  

        if ($this->core->data_sanction[$i]->iteration == 6) { //هذا في حاله كان الخيار اي مره
           

            $this->details->sanction();


        }
        if (count($extra) == $this->core->data_sanction[$i]->iteration) { //هذا في حاله كان الخيار عدد المرات

            $this->details->sanction();

        }
    }
}
