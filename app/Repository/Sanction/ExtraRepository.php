<?php

namespace App\Repository\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Traits\staff\Sanction\ExtraSanctionTrait;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;
class ExtraRepository implements SanctionRepositoryInterface
{
    use SanctionTrait, ExtraSanctionTrait;
    public $attendance_core;

    public function create($attendance_core)
    {

        $this->attendance_core = $attendance_core;
        
        $data  = $this->get();
        $day = date('l', strtotime($attendance_core->data['attendance_date']));
   
        $this->current_attendance('extra');
        
        $iterat = $this->all_attendance('extra');

        foreach ($data as $key => $value) {

            if ($value->extra_type_id == 1) {

                if ($iterat == $value->iteration) {

                    $attendance_core->sanction_type_id = $value->extra_type_id;
                    $this->handle();
                }
            }

            if ($value->extra_type_id == 2) {

                if ($iterat == $value->iteration) {

                      $attendance_core->sanction_type_id = $value->extra_type_id;
                      $this->handle();
                }
            }

        }
    }


    public function handle()
    {


        $this->get_sanction('ExtraSanction');
        $this->staff_sanction();
        // $this->payroll('total_extra');

    }
}
