<?php

namespace App\Services\Staff;

use App\RepositoryInterface\PayrollRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\staff\Sanction\ExtraSanctionTrait;
use App\Services\CoreStaffService;
use App\Services\Core\SanctionService;
use Illuminate\Support\Facades\DB;

class ExtraService extends SanctionService
{

    use ExtraSanctionTrait;

    public function __construct(

        protected PayrollRepositoryInterface $payroll,
        protected DetailRepositoryInterface $details,
        protected CoreStaffService $core,

    ) {
    }


    public function create()
    {

        // if ($this->core->temporale_f->isEmpty()) {
        //     return 0;
        // }

        $data  = $this->get();  //this get extra_sanctions

        // -------------------------------------this calc from extra_table-----------------------------------------------------------
        $extra = DB::table('extras')->where('number_hours', $this->core->data['duration'][$this->core->value][0])->get();

        for ($i = 0; $i < count($data); $i++) {

            $this->core->status_sanction = false;


            if ($this->core->data['extra_type'][$this->core->value] == $data[$i]->extra_type_id) {



                $this->check_type($i, $data, $extra);
            }
            
        }


        return $this;
    }


    public function check_type($i, $data, $extra)
    {



        if ($i == 0) {

            $this->state_one($i, $data, $extra);
        }


        if ($this->core->status_sanction != true) {

            $this->state_tow($i, $data, $extra);
        }



        if ($i + 1 < count($data) && $this->core->status_sanction != true) {

            $this->state_three($i, $data, $extra);
        }
    }
    public function state_one($i, $data, $extra)
    {


        if (($this->core->data['duration'][$this->core->value][0]) < ($data[$i]->duration)) {
            
            $this->handle($i, $data, $extra);
        }
    }

    public function state_tow($i, $data, $extra)
    {





        if ($this->core->data['duration'][$this->core->value][0] == $data[$i]->duration) {



            $this->handle($i, $data, $extra);
        }
    }

    public function state_three($i, $data, $extra)
    {


        if (
            ($this->core->data['duration'][$this->core->value][0]) > ($data[$i]->duration) &&
            ($this->core->data['duration'][$this->core->value][0]) < ($data[$i + 1]->duration)

        ) {



            $this->handle($i, $data, $extra);
        }
    }


    public function handle($i, $data, $extra)
    {



        if (count($extra) == $data[$i]->iteration) {

            $this->details->init_details(value: $data[$i]);

            $this->payroll->refresh($this->core->data['staff'][$this->core->value], $data[$i]);
        }
    }
}
