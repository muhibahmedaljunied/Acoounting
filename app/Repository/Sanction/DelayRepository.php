<?php

namespace App\Repository\Sanction;
use App\Models\DelaySanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use DB;
class DelayRepository implements SanctionRepositoryInterface,PayrollRepositoryInterface,SingleSanctionRepositoryInterface
{
    use SanctionTrait;
    public function add($request, $value)
    {

        $temporale = new DelaySanction();
        $temporale->delay_type_id = $request['delay'][$value];
        $temporale->part_id = $request['delay_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->discount = $request['discount'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;
    }

    public function update($temporale, $request)
    {

        $temporale_f = tap(DelaySanction::whereDelaySanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');


        return $temporale_f;
    }

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
        // ----------------------------------------------------------------------------
    

    }

    public function get()
    {

        $delay = DB::table('delay_sanctions')
            ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select('delay_sanctions.*', 'delay_sanctions.id as delay_sanction_id', 'parts.duration', 'delay_types.*', 'sanction_discounts.*')
            ->get();
        return $delay;
    }

   


    public function handle($request,$delay_sanction_id,$val,$id){


        // $de = DelaySanction::find($delay_sanction_id);
        $de = $this->get_sanction($delay_sanction_id,'DelaySanction');
        $this->staff_sanction($request, $val, $id, $de);

        $this->refresh($request,$de);


    }
   

    

    
}
