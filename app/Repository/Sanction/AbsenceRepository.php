<?php

namespace App\Repository\Sanction;

use App\RepositoryInterface\SanctionRepositoryInterface;
use App\Traits\Staff\Sanction\SanctionTrait;
use App\Models\AbsenceSanction;
use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use App\User;
use DB;

class AbsenceRepository implements SanctionRepositoryInterface,SingleSanctionRepositoryInterface {



    use SanctionTrait;

    public function add($request,$value){

        $temporale = new AbsenceSanction();
        $temporale->absence_type_id = $request['absence'][$value];
        // $temporale->part_id = $request['absence_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->discount = $request['discount'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;

    }
    
    public function update($temporale, $request)
    {

        $temporale_f = tap(AbsenceSanction::whereAbsenceSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');


        return $temporale_f;
    }


    public function create($id, $request, $val)
    {

        $data  = $this->get();
        $day = date('l', strtotime($request['attendance_date']));
        $leave_current = $this->current_attendance($id,'absence');

        $iterat = $this->all_attendance($leave_current,'absence');
        //   $iterat = DB::table('attendances')->where('attendance_status',0)->get();
     
        foreach ($data as $key => $value) {
     
            if ($value->absence_type_id == 1 &&  $day == 'Saturday') {

          
                if ($iterat == $value->iteration) {
                   
                    $this->handle($request,$value->absence_sanction_id,$val,$id);

              
                }
            }
         
        }
    
    }
    public function get()
    {

        $absence = DB::table('absence_sanctions')
            ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
            // ->join('parts', 'parts.id', '=', 'absence_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
            ->select('absence_sanctions.*', 'absence_sanctions.id as absence_sanction_id', 'absence_types.*', 'sanction_discounts.*')
            ->get();
        return $absence;
    }

    public function handle($request,$absence_sanction_id,$val,$id){

     
        // $de = AbsenceSanction::find($absence_sanction_id);
        $de = $this->get_sanction($absence_sanction_id,'AbsenceSanction');
        $this->staff_sanction($request, $val, $id, $de);
        $this->refresh($request, $de);


    }
   
   
}