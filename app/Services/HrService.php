<?php

namespace App\Services;
use App\Models\StoreProduct;
use App\Models\Stock;
use App\Models\Extra;
use Illuminate\Http\Request;
use DB;

class HrService
{

    // function Sum($data,$table){


    //     switch ($table) {
    //         case 'extra':

    //             foreach ($data as $sub) {

    //                 $sub->sum_number_hours =0;
    //                 foreach ($sub->extra as $key => $value) {
                        
    //                     $sub->sum_number_hours += $value->number_hours;
        
        
    //                 }
    //             }
                
    //             break;

    //         case 'advance':

    //             foreach ($data as $sub) {

    //                 $sub->sum_advanve =0;
    //                 foreach ($sub->advance as $key => $value) {
                        
    //                     $sub->sum_advanve += $value->quantity;
        
        
    //                 }
    //             }
                
    //             break;

    //         case 'discount':

    //             foreach ($data as $sub) {

    //                 $sub->sum_discount =0;
    //                 foreach ($sub->discount as $key => $value) {
                        
    //                     $sub->sum_discount += $value->quantity;
        
        
    //                 }
    //             }
                
    //             break;

    //         case 'vaction':


    //             foreach ($data as $sub) {

    //                 $sub->sum_vacation =0;
    //                 foreach ($sub->vacation as $key => $value) {
                        
    //                     $sub->sum_vacation += $value->total_days;
        
        
    //                 }
    //             }
                
    //             break;
            
    //         default:
                
    //             break;
    //     }
        
      
    // }
    // function add(...$list_data)
    // {

    //     $attendance_id  = 0 ;
    //     $request = $list_data['request'];
    //     $value = $list_data['value'];
    //     $type = $list_data['type'];
        
    //     switch ($type) {

     
    //         case 'extra':

    //             $temporale = new Extra();
    //             $temporale->staff_id = $request['staff'][$value];
    //             $temporale->extra_type_id = $request['extra_type'][$value];
    //             $temporale->date = $request['date'][$value];
    //             $temporale->start_time = $request['start_time'][$value];
    //             $temporale->end_time = $request['end_time'][$value];
    //             $temporale->number_hours = $request['duration'][$value][0];
    //             break;

 
    //         case 'discount':
    //             $temporale = new Discount();
    //             $temporale->staff_id = $request['staff'][$value];
    //             $temporale->discount_type_id = $request['discount_type'][$value];
    //             $temporale->quantity = $request['qty'][$value];
    //             $temporale->date = $request['date'][$value];
    //             break;

    //         case 'allowance':
    //             $temporale = new Allowance();
    //             $temporale->staff_id = $request['staff'][$value];
    //             $temporale->status = $request['allowance_status'][$value];
    //             $temporale->allowance_type_id = $request['allowance_type'][$value];
    //             $temporale->qty = $request['qty'][$value];
    //             // $temporale->date = $request['date'][$value];
    //             break;
    //         case 'advance':
    //             $temporale = new Advance();
    //             $temporale->staff_id = $request['staff'][$value];
    //             // $temporale->extra_type_id = $request->post('extra_type')[$value];
    //             $temporale->date = $request['date'][$value];
    //             $temporale->quantity = $request['qty'][$value];
    //             break;
    //         case 'leave':
    //             $temporale = new Vacation();
    //             $temporale->staff_id = $request['staff'][$value];
    //             $temporale->vacation_type_id = $request['leave_type'][$value];
    //             $temporale->start_date = $request['start_date'][$value];
    //             $temporale->end_date = $request['end_date'][$value];
    //             $temporale->total_days = $request['days'][$value];
    //             // $temporale->total_days = $request->post('days')[$value];
    //             // return $request['days'][$value];
    //             break;
   
        
       
                      
    //     }


    //     $temporale->save();
    //     return $temporale->id;
    // }

    // function refresh ($request,$value,$type){

    //     switch ($type) {
    //         case 'extra':
                
    //             $temporale_f = tap(Extra::whereExtra($request))
    //             ->update([
    //                 'date' => $request['date'][$value],
    //                 'start_time' => $request['start_time'][$value],
    //                 'end_time' => $request['end_time'][$value],
    //                 'number_hours' => $request['duration'][$value]
    //             ])
    //             ->get('id');

    //             return $temporale_f;
                            
    //         default:

    //             break;
    //     }
    // }
   

}
