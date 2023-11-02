<?php

namespace App\Services;

use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\staff\AttendanceTrait;
use App\Services\core\CoreStaffAttendanceService;
use Illuminate\Http\Request;
use DB;

class AttendanceDetailService
{

    use AttendanceTrait;
    public function __construct(
        protected DetailRepositoryInterface $details,
        protected CoreStaffAttendanceService $attendance_core,
        protected Request $request,
    ) {

     

       
       
    }


    function add_and_refresh_details()
    {
        $this->refresh_details();

        $this->init_details();
    }

    public function init_details()
    {


        if ($this->attendance_core->data['attendance_in_out'] == 1) {

            $this->init_details_table(
                $this->attendance_core->data,
                $this->attendance_core->attendance_id,
                $this->attendance_core->value
            );
        }
    }


    public function refresh_details()
    {


        if ($this->attendance_core->data['attendance_in_out'] == 2) {

            $this->refresh_details_table();

            $this->sanction();
        }
    }


    public function sanction()
    {
       

        if ($this->attendance_core->data['attendance_final'] == 'complete' && $this->attendance_core->data['code'] == 'B') {


            foreach (config('sanction.data_sanction') as $value_sanction) {

                if ($value_sanction != 'absence_sanction') {
                 
               
                    $repo = app($value_sanction)
                    ->create($this->attendance_core);
                    // dd($repo);

                    // if ($value_sanction != 'absence_sanction') {

                    // dd(app('delay_sanction'));

                    // $repo = app($value_sanction)
                    // ->get($value_sanction)
                    // ->create();



                }
            }

            // dd(1);
            // $this->sanction->create();
        }
    }
}
