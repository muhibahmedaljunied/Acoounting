<?php

namespace App\Services\Sanction;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class DelaySanctionService implements SanctionRepositoryInterface
{
    use SanctionTrait;

  

    function create($id, $request, $val)
    {


        $data  = $this->get();


        $day = date('l', strtotime($request['attendance_date']));
        $delay_current = $this->current_attendance($id);
        // $delay_current = 15;
        // return $delay_current;
        $iterat = $this->all_attendance($delay_current);
        // return $iterat;
        foreach ($data as $key => $value) {
            // return $value;
            if ($value->delay_type_id == 1 &&  $day == 'Saturday') {

                // return $request;
                if ($iterat == $value->iteration) {

                    $result = $this->sanction_finshed($id, $request, $val, $value, $type);
                    return $result;
                }
            }
        }
        // ----------------------------------------------------------------------------


    }
}
