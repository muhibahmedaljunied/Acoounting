<?php

namespace App\Repository\Sanction;

use App\Traits\Staff\Sanction\SanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Services\core\CoreStaffAttendanceService;
use App\Traits\staff\Sanction\LeaveSanctionTrait;

use DB;

class LeaveRepository  implements SanctionRepositoryInterface
{

    use SanctionTrait, LeaveSanctionTrait;
    public $attendance_core;

    public function create($attendance_core)
    {

        $this->attendance_core = $attendance_core;

        $data  = $this->get();
        $day = date('l', strtotime($attendance_core->data['attendance_date']));
        $this->current_attendance($attendance_core->attendance_id, 'leave');

        $iterat = $this->all_attendance('leave');


        foreach ($data as $key => $value) {


            // if ($value->code == $attendance_core->data['type_leave_delay'] && $value->duration == $attendance_core->data['leave'][$attendance_core->value]) {
            if ($value->leave_type_id == 1 &&  $day == 'Saturday') {


                if ($iterat == $value->iteration) {

                    $attendance_core->sanction_type_id = $value->leave_type_id;
                    $this->handle();
                }
            }
        }
    }



    public function handle()
    {

        $this->get_sanction('LeaveSanction');
        $this->staff_sanction();
        $this->payroll();
    }
}
