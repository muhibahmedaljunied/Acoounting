<?php

namespace App\Services\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Models\ExtraSanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class ExtraSanctionService implements SanctionRepositoryInterface
{
    use SanctionTrait;

   

    function create($id, $request, $val)
    {


        $data  = $this->get();


        $day = date('l', strtotime($request['attendance_date']));
        $extra_current = $this->current_attendance($id);
        // $leave_current = 15;

        // return $leave_current;
        $iterat = $this->all_attendance($extra_current);
        // return $iterat;
        foreach ($data as $key => $value) {

            // return $type;

            if ($value->extra_type_id == 1 &&  $day == 'Saturday') {

                if ($iterat == $value->iteration) {

                    $result = $this->sanction_finshed($id, $request, $val, $value, $type);
                    
                    return $result;
                }
            }
        }
    }
}
