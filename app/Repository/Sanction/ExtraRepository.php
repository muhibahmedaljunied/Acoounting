<?php

namespace App\Repository\Sanction;
use App\Models\ExtraSanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use DB;
class ExtraRepository implements SanctionRepositoryInterface,PayrollRepositoryInterface,SingleSanctionRepositoryInterface
{

    use SanctionTrait;

    public function add($request, $value)
    {

        $temporale = new ExtraSanction();
        $temporale->extra_type_id = $request['extra'][$value];
        $temporale->part_id = $request['extra_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;

    }

    public function update($temporale, $request)
    {

        $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');

        return $temporale_f;
    }

    public function create($id, $request, $val)
    {

        $data  = $this->get();
     
        $day = date('l', strtotime($request['attendance_date']));
        $extra_current = $this->current_attendance($id,'extra');
    
        $iterat = $this->all_attendance($extra_current,'extra');

        foreach ($data as $key => $value) {
   
            if ($value->extra_type_id == 1 &&  $day == 'Saturday') {
              
                if ($iterat == $value->iteration) {

                 
                   $this->handle($request,$value->extra_sanction_id,$val,$id);
            
                
                }
            }
    
            // if ($value->extra_type_id == 1 &&  $day == 'Thurisday') {

            //     if ($iterat == $value->iteration) {

            //         $result = $this->sanction_finshed($id, $request, $val, $value, $type);
            //         return $result;
            //     }
            // }

        }

   
    }


    public function handle($request,$extra_sanction_id,$val,$id){

    
        $de = $this->get_sanction($extra_sanction_id,'ExtraSanction');
        $this->staff_sanction($request, $val, $id, $de);
        $qw = $this->refresh($request, $de,'total_extra');
        return $qw;


    }


    public function get()
    {

        $extra = DB::table('extra_sanctions')
            ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('extra_sanctions.*', 'extra_sanctions.id as extra_sanction_id', 'parts.duration', 'extra_types.*', 'sanction_discounts.*')
            ->get();
        return $extra;
    }

    
   

}
