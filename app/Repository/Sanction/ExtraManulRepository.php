<?php

namespace App\Repository\Sanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Traits\staff\Sanction\ExtraSanctionTrait;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\CoreStaffService;
use DB;
class ExtraManulRepository implements SanctionRepositoryInterface,PayrollRepositoryInterface
{

    use SanctionTrait,ExtraSanctionTrait;


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



            if ($this->core->data['extra_type'][$this->core->value] == $data[$i]->extra_type_id) {



                if ($i == 0) {
                    $this->state_one($i, $data, $extra);
                }

                $this->state_tow($i, $data, $extra);

                if ($data[$i + 1]->duration) {
                    $this->state_three($i, $data, $extra);
                }
            }
            dd(1);
        }


        return $this;
    }


    public function state_one($i, $data, $extra)
    {




        if (
            ($this->core->data['duration'][$this->core->value][0]) < ($data[$i]->duration)
        ) {

            // dd('yesyes2');
            $this->handle($i, $data, $extra);
        }
    }

    public function state_tow($i, $data, $extra)
    {


        if ($this->core->data['duration'][$this->core->value][0] == $data[$i]->duration) {

            // dd('yes');
            $this->handle($i, $data, $extra);
        }
    }

    public function state_three($i, $data, $extra)
    {

        // dd('yesyes');
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


            // dd($this->details);
            $this->details->init_details(value: $data[$i]);
            
            $this->payroll->refresh($this->core->data['staff'][$this->core->value], $data[$i]);
        }
    }


    
}
