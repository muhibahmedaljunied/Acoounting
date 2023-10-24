<?php

namespace App\Repository\Sanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\Traits\staff\Sanction\DelaySanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use DB;
class DelayRepository implements SanctionRepositoryInterface,PayrollRepositoryInterface
{
    use SanctionTrait,DelaySanctionTrait;
 
    
    public function create($id, $request, $val)
    {
 
        $data  = $this->get();
      
        $delay_current = $this->current_attendance($id,'delay');
        $iterat = $this->all_attendance($delay_current,'delay');
        foreach ($data as $key => $value) {

            if ($value->code == $request['type_leave_delay'] && $value->duration == $request['delay'][$val]) {

                if ($iterat == $value->iteration) {

                    $this->handle($request,$value->delay_sanction_id,$val,$id);

                }
            }
          
        }
    

    }

 

   


    public function handle($request,$delay_sanction_id,$val,$id){

        // $de = DelaySanction::find($delay_sanction_id);
        $de = $this->get_sanction($delay_sanction_id,'DelaySanction');
        $this->staff_sanction($request, $val, $id, $de);
        $this->refresh($request,$de);


    }
   

    

    
}
