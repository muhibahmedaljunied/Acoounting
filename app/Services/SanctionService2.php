<?php

namespace App\Services;

use App\Models\AbsenceSanction;
use App\Models\DelaySanction;
use App\Models\ExtraSanction;
use App\Models\LeaveSanction;
use App\Traits\Staff\Sanction\SanctionTrait;
use DB;

class SanctionService
{
    use SanctionTrait;



    // function update($temporale, $request, $type)
    // {


    //     switch ($type) {

    //         case 'extra_sanction':
    //             $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
    //                 ->update(['sanction' => $request['sanction']])
    //                 ->get('id');

    //             break;

    //         case 'absence_sanction':
    //             $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
    //                 ->update(['sanction' => $request['sanction']])
    //                 ->get('id');

    //             break;



    //         case 'delay_sanction':

    //             $temporale_f = tap(DelaySanction::whereDelaySanction($request))
    //                 ->update(['sanction' => $request['sanction']])
    //                 ->get('id');


    //             break;




    //         case 'leave_sanction':
    //             $temporale_f = tap(LeaveSanction::whereLeaveSanction($request))
    //                 ->update(['sanction' => $request['sanction']])
    //                 ->get('id');

    //             break;

    //         default:

    //             break;
    //     }


    //     return $temporale_f;
    // }
    // function add(...$list_data)
    // {
        
    //     $request = $list_data['request'];
    //     $value = $list_data['value'];
    //     $type = $list_data['type'];

    //     switch ($type) {

    //         case 'absence_sanction':
    //             $temporale = new AbsenceSanction();
    //             $temporale->absence_type_id = $request['absence'][$value];
    //             $temporale->iteration = $request['iteration'][$value];
    //             $temporale->sanction_discount_id = $request['discount_type'][$value];
    //             $temporale->discount = $request['discount'][$value];
    //             $temporale->sanction = $request['sanction'][$value];


    //             break;
    //         case 'delay_sanction':
    //             $temporale = new DelaySanction();
    //             $temporale->delay_type_id = $request['delay'][$value];
    //             $temporale->part_id = $request['delay_part'][$value];
    //             $temporale->iteration = $request['iteration'][$value];
    //             $temporale->sanction_discount_id = $request['discount_type'][$value];
    //             $temporale->discount = $request['discount'][$value];
    //             $temporale->sanction = $request['sanction'][$value];


    //             break;
    //         case 'extra_sanction':
    //             $temporale = new ExtraSanction();
    //             $temporale->extra_type_id = $request['extra'][$value];
    //             $temporale->part_id = $request['extra_part'][$value];
    //             $temporale->iteration = $request['iteration'][$value];
    //             $temporale->sanction_discount_id = $request['discount_type'][$value];
    //             $temporale->sanction = $request['sanction'][$value];


    //             break;
    //         case 'leave_sanction':
    //             $temporale = new LeaveSanction();
    //             $temporale->leave_type_id = $request['leave'][$value];
    //             $temporale->part_id = $request['leave_part'][$value];
    //             $temporale->iteration = $request['iteration'][$value];
    //             $temporale->sanction_discount_id = $request['discount_type'][$value];
    //             $temporale->discount = $request['discount'][$value];
    //             $temporale->sanction = $request['sanction'][$value];


    //             break;
    //     }


    //     $temporale->save();
    //     return $temporale->id;
    // }

    // function get($type)
    // {

    //     $table = $type;
    //     $two = 'extra';


    //     $data = DB::table($type)
    //         ->join($two.'_types', $two.'_types.id', '=', $two.'_sanctions.'.$two.'_type_id')
    //         ->join('parts', 'parts.id', '=', $two.'_sanctions.part_id')
    //         ->join('sanction_discounts', 'sanction_discounts.id', '=', $two.'_sanctions.sanction_discount_id')
    //         ->select($two.'_sanctions.*', $two.'_sanctions.id as '.$two.'_sanction_id', 'parts.duration', $two.'_types.*', 'sanction_discounts.*')
    //         ->get();
    //     return $data;



        // switch ($type) {

        //     case 'extra_sanction':

        //         $extra = DB::table('extra_sanctions')
        //             ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
        //             ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
        //             ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
        //             ->select('extra_sanctions.*', 'extra_sanctions.id as extra_sanction_id', 'parts.duration', 'extra_types.*', 'sanction_discounts.*')
        //             ->get();
        //         return $extra;

        //     case 'absence_sanction':
        //         break;


        //     case 'delay_sanction':
        //         $delay = DB::table('delay_sanctions')
        //             ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
        //             ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
        //             ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
        //             ->select('delay_sanctions.*', 'delay_sanctions.id as delay_sanction_id', 'parts.duration', 'delay_types.*', 'sanction_discounts.*')
        //             ->get();
        //         return $delay;

        //     case 'leave_sanction':
        //         $leave = DB::table('leave_sanctions')
        //             ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
        //             ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
        //             ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
        //             ->select('leave_sanctions.*', 'leave_sanctions.id as leave_sanction_id', 'parts.duration', 'leave_types.*', 'sanction_discounts.*')
        //             ->get();
        //         return $leave;

        //         break;

        //     default:
        //         # code...
        //         break;
        // }
    // }

    // function create($id, $request, $val, $type)
    // {


    //     $data  = $this->get($type);

    //     switch ($type) {

    //         case 'extra_sanction':

    //             // -------------------------------------this calc from attendance_table-----------------------------------------------------------

    //             $day = date('l', strtotime($request['attendance_date']));
    //             $extra_current = $this->current_attendance($id);
    //             $iterat = $this->all_attendance($extra_current);
    
    //             foreach ($data as $key => $value) {

    //                 if ($value->extra_type_id == 1 &&  $day == 'Saturday') {

    //                     if ($iterat == $value->iteration) {

    //                         $result = $this->sanction_finshed($id, $request, $val, $value, $type);
    //                         return $result;
    //                     }
    //                 }
    //             }

           

    //             break;


    //         case 'leave_sanction':

    //             $day = date('l', strtotime($request['attendance_date']));
    //             $leave_current = $this->current_attendance($id);
    //             $iterat = $this->all_attendance($leave_current);
 
    //             foreach ($data as $key => $value) {

        

    //                 if ($value->leave_type_id == 1 &&  $day == 'Saturday') {

    //                     if ($iterat == $value->iteration) {

    //                         $result = $this->sanction_finshed($id, $request, $val, $value, $type);
    //                         return $result;
    //                     }
    //                 }
    //             }
    //             break;



    //         case 'absence_sanction':
    //             $extra = DB::table('extras')->where('number_hours', $request['duration'][$val][0])->get();
    //             $result = 0;
    //             foreach ($data as $key => $value) {
    //                 if ($request['extra_type'][$val] == $value->extra_type_id &&  $request['duration'][$val][0] == $value->duration) {


    //                     if (count($extra) == $value->iteration) {

    //                         $result = $this->sanction_finshed($id, $request, $val, $data, $type);
    //                         return $result;
    //                     }
    //                 }
    //             }

    //             break;



    //         case 'delay_sanction':

    //             $day = date('l', strtotime($request['attendance_date']));
    //             $delay_current = $this->current_attendance($id);
         

   
    //             $iterat = $this->all_attendance($delay_current);
    
    //             foreach ($data as $key => $value) {

          

    //                 if ($value->delay_type_id == 1 &&  $day == 'Saturday') {

    //                     if ($iterat == $value->iteration) {

    //                         $result = $this->sanction_finshed($id, $request, $val, $value, $type);
    //                         return $result;
    //                     }
    //                 }
    //             }
    //             // ----------------------------------------------------------------------------


    //         default:
    //             break;
    //     }
    // }
    

   
}
