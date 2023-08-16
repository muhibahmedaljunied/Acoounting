<?php

namespace App\Services;

use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;

use DB;

class ExtraService
{

    public function __construct(
        protected DetailRepositoryInterface $details,
        protected SanctionRepositoryInterface $sanction,
        protected PayrollRepositoryInterface $payroll,
    ) {
        $this->details = $details;
        $this->sanction = $sanction;
        $this->payroll = $payroll;
    }


   
    public function create($id, $request, $val)
    {

        $data  = $this->sanction->get();

        // -------------------------------------this calc from extra_table-----------------------------------------------------------
        $extra = DB::table('extras')->where('number_hours', $request['duration'][$val][0])->get();
        $result = 0;
        foreach ($data as $key => $value) {
            if ($request['extra_type'][$val] == $value->extra_type_id &&  $request['duration'][$val][0] == $value->duration) {

                // return 'muhib';
                if (count($extra) == $value->iteration) {

                    // $result = $this->finshed($id, $request, $value);
                    $result = $this->details->init_details(id:$id, request:$request, value:$value);
                    $this->payroll->refresh($request['staff'][$val],$value);

                    // return $result;
                }
            }
        }

        
    }
}
