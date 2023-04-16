<?php

namespace App\Traits\Staff\BasicData;


use Illuminate\Http\Request;
use App\Models\WorkSystem;
use App\Models\WorkType;
use DB;

trait StoreTrait
{

   

    public function store(Request $request)
    {

        // return response()->json(['work_types'=>$request->all()]);

        foreach ($request->post('count') as $value) {



   
         
        
            if ($request->post('type') == 'work_system') {

                // return response()->json(['message' => $request['day'][$value]]);
                $temporale = new WorkSystem();
                $temporale->work_type_id = $request['work_type'][$value];
                $temporale->period_id = $request['period'][$value];
                $temporale->rest_id = $request['rest'][$value];
                $temporale->day_id = json_encode($request['day'][$value]);
                $temporale->save();
            }

            if ($request->post('type') == 'work_type') {

               
                $temporale = new WorkType();
                $temporale->name = $request['name'][$value];
                $temporale->save();
           
            }

            


            // if ($request->post('type') == 'discount') {

            //     $temporale_f = tap(Discount::where(['staff_id' => $request['staff'][$value], 'discount_type_id' => $request['discount_type'][$value], 'date' => $request['date'][$value]]))
            //         ->update(['quantity' => $request['qty'][$value]])
            //         ->get('id');
            //     $this->refresh_payroll($request->all(), $value, $request->post('type'));
            // }
            // if ($request->post('type') == 'allowance') {

            //     // $temporale_f = tap(Allowance::where(['staff_id' => $request['staff'][$value], 'allowance_type_id' => $request['allowance_type'][$value]]))
            //     //     ->update(['qty' => $request['qty'][$value]])
            //     //     ->get('id');
            //     // $this->refresh_payroll($request->all(), $value, $request->post('type'));

            //     $this->add($request->all(), $value, $request->post('type'));
            //     $this->refresh_payroll($request->all(), $value, $request->post('type'));
            //     return response()->json(['message' => $request->all()]);
            // }


            // if ($request->post('type') == 'advance') {
            //     // return response()->json(['message' => $request->all()]);

            //     $temporale_f = tap(Advance::where(['staff_id' => $request['staff'][$value],'date' => $request['date'][$value]]))
            //         ->update(['quantity' => $request['qty'][$value]])
            //         ->get('id');
            //     $this->refresh_payroll($request->all(), $value, $request->post('type'));
            // }

            // if ($request->post('type') == 'leave') {

                
            //     $temporale_f = tap(Vacation::where(['staff_id' => $request['staff'][$value], 'vacation_type_id' => $request['leave_type'][$value],'start_date' => $request['start_date'][$value], 'end_date' => $request['end_date'][$value]]))
            //         ->update(['total_days' => $request['days']])
            //         // ->update(['total_days' => $request['days'][$value]])
            //         ->get('id');
            // }
            // if ($request->post('type') == 'absence_sanction') {

            //     // return response()->json(['message' => $request->all()]);
            //     $temporale_f = tap(AbsenceSanction::where(['staff_id' => $request['staff'][$value], 'absence_type_id' => $request['absence'][$value],'iteration' => $request['iteration'][$value], 'sanction_discount_id' => $request['discount_type'][$value], 'discount' => $request['discount'][$value]]))
            //         ->update(['sanction' => $request['sanction']])
            //         ->get('id');
            // }
            // if ($request->post('type') == 'delay_sanction') {

            //     return response()->json(['message' => $request->all()]);
            //     $temporale_f = tap(DelaySanction::where(['staff_id' => $request['staff'][$value], 'delay_type_id' => $request['delay'][$value],'iteration' => $request['iteration'][$value], 'discount_type' => $request['discount_type'][$value], 'discount' => $request['discount'][$value]]))
            //         ->update(['sanction' => $request['sanction']])
            //         ->get('id');
            // }
            // if ($request->post('type') == 'extra_sanction') {

                
            //     $temporale_f = tap(ExtraSanction::where(['staff_id' => $request['staff'][$value], 'extra_type_id' => $request['extra'][$value],'extra_part_id' => $request['extra_part'][$value],'iteration' => $request['iteration'][$value], 'discount_type' => $request['discount_type'][$value], 'discount' => $request['discount'][$value]]))
            //         ->update(['sanction' => $request['sanction']])
            //         ->get('id');
            // }
            // if ($request->post('type') == 'leave_sanction') {

                
            //     $temporale_f = tap(LeaveSanction::where(['staff_id' => $request['staff'][$value], 'leave_type_id' => $request['leave'][$value],'leave_part_id' => $request['leave_part'][$value],'iteration' => $request['iteration'][$value],'discount' => $request['discount'][$value]]))
            //         ->update(['sanction' => $request['sanction']])
            //         ->get('id');
            // }


          
            // if ($temporale_f->isEmpty()) {

               

            //  $this->add($request->all(), $value, $request->post('type'));
            // }
            // }
        }




        return response()->json(['message' => $request->all()]);
    }
}
