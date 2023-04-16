<?php

namespace App\Traits\Staff;

use App\Models\Attendance;
use App\Models\Extra;
use App\Models\Discount;
use App\Models\Advance;
use App\Models\AttendanceDetail;
use App\Models\AbsenceSanction;
use App\Models\DelaySanction;
use App\Models\ExtraSanction;
use App\Models\LeaveSanction;
use App\Models\Vacation;
use App\Traits\Staff\TemporaleTrait;
use Illuminate\Http\Request;
use DB;

trait StoreTrait
{

    use TemporaleTrait;

    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


// return response()->json(['message' => $request->all()]);
            $temporale_f = 0;
   
            // if ($value !== null) {
            if ($request->post('type') == 'attendance') {

             

                $attendance_id = Attendance::where(['attendances.staff_id'=>$request['staff'][$value],'attendances.attendance_date'=>$request['attendance_date'][$value]])
                ->select('attendances.id')
                ->get();
               
                // return response()->json(['message' => $attendance_id]);
                
                if(!$attendance_id->isEmpty()){
                    
                    foreach ($attendance_id as $values) {


                        $attendance_id = $values['id'];
                    }

                    if($request['attendance_in_out'] == 1){

                        $updating_data = ['attendance_status' => $request->post('attendance_status')[$value], 'check_in' => $request->post('time_in')[$value]];
                       
                    }else{
                        
                        $updating_data = ['attendance_status' => $request->post('attendance_status')[$value],'check_out' => $request->post('time_out')[$value]];

                    }
                    // return response()->json(['message' => $updating_data]);
                    $temporale_f = tap(AttendanceDetail::where(['attendance_id' => $attendance_id, 'period_id' => $request['period']]))
                    ->update($updating_data)
                    ->get('id');

                    if ($temporale_f->isEmpty()) {
                        $details = new AttendanceDetail();
                        $details->attendance_id =  $attendance_id;
                        $details->period_id =  $request['period'];
                        $details->attendance_status = $request['attendance_status'][$value];
                        if($request['attendance_in_out'] == 1){
                            $details->check_in = $request['time_in'][$value];
                           
                        }else{
                            $details->check_out = $request['time_out'][$value];
                        }
                        
                        $details->duration = $request['duration'][$value];
                        $details->delay = $request['delay'][$value];
                        $details->leave = $request['leave'][$value];
                        $details->save();
                    }


                  

                }else{

                    $attendance = new Attendance();
                    $attendance->staff_id =  $request['staff'][$value];
                    $attendance->attendance_date = $request['attendance_date'][$value];
                    $attendance->attendance_status = $request['attendance_status'][$value];
                    $attendance->save();

                    $attendance_id = $attendance->id;
                    // --------------------------------------------------------------
                    foreach ($attendance_id as $values) {

                        $attendance_id = $values['id'];
                    }
                    // --------------------------------------------------------------
                    $details = new AttendanceDetail();
                    $details->attendance_id =  $attendance_id;
                    $details->period_id =  $request['period'];
                    $details->attendance_status = $request['attendance_status'][$value];
                    if($request['attendance_in_out'] == 1){
                        $details->check_in = $request['time_in'][$value];
                       
                    }else{
                        $details->check_out = $request['time_out'][$value];
                    }
                    
                    $details->duration = $request['duration'][$value];
                    $details->delay = $request['delay'][$value];
                    $details->leave = $request['leave'][$value];
                    $details->save();
                    


                    
                }
              
            }
            if ($request->post('type') == 'extra') {

                $date1 = $request['start_time'][$value];
                $date2 = $request['end_time'][$value];
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hour = abs($timestamp2 - $timestamp1) / (60 * 60) . " hour(s)";
                $quantity = intval($hour)*intval(1000);

                $temporale_f = tap(Extra::where(['staff_id' => $request['staff'][$value], 'extra_type_id' => $request['extra_type'][$value]]))
                    ->update(['date' => $request['date'][$value], 'start_time' => $request['start_time'][$value], 'end_time' => $request['end_time'][$value],'number_hours' =>intval($hour)])
                    ->get('id');
                // return response()->json(['message' => $request->all()]);
                // $this->refresh_payroll($request->all(), $request->post('type'));
            }

            if ($request->post('type') == 'discount') {

                $temporale_f = tap(Discount::where(['staff_id' => $request['staff'][$value], 'discount_type_id' => $request['discount_type'][$value], 'date' => $request['date'][$value]]))
                    ->update(['quantity' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            if ($request->post('type') == 'allowance') {

                // $temporale_f = tap(Allowance::where(['staff_id' => $request['staff'][$value], 'allowance_type_id' => $request['allowance_type'][$value]]))
                //     ->update(['qty' => $request['qty'][$value]])
                //     ->get('id');
                // $this->refresh_payroll($request->all(), $value, $request->post('type'));

                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
                return response()->json(['message' => $request->all()]);
            }


            if ($request->post('type') == 'advance') {
                // return response()->json(['message' => $request->all()]);

                $temporale_f = tap(Advance::where(['staff_id' => $request['staff'][$value],'date' => $request['date'][$value]]))
                    ->update(['quantity' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }

            if ($request->post('type') == 'leave') {

                
                $temporale_f = tap(Vacation::where(['staff_id' => $request['staff'][$value], 'vacation_type_id' => $request['leave_type'][$value],'start_date' => $request['start_date'][$value], 'end_date' => $request['end_date'][$value]]))
                    ->update(['total_days' => $request['days']])
                    // ->update(['total_days' => $request['days'][$value]])
                    ->get('id');
            }
            if ($request->post('type') == 'absence_sanction') {

                // return response()->json(['message' => $request->all()]);
                $temporale_f = tap(AbsenceSanction::where(['staff_id' => $request['staff'][$value], 'absence_type_id' => $request['absence'][$value],'iteration' => $request['iteration'][$value], 'sanction_discount_id' => $request['discount_type'][$value], 'discount' => $request['discount'][$value]]))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }
            if ($request->post('type') == 'delay_sanction') {

                // return response()->json(['message' => $request->all()]);return response()->json(['message' => $request->all()]);
                $temporale_f = tap(DelaySanction::where(['staff_id' => $request['staff'][$value], 'delay_type_id' => $request['delay'][$value],'delay_part_id' => $request['delay_part'][$value],'iteration' => $request['iteration'][$value], 'sanction_discount_id' => $request['discount_type'][$value], 'discount' => $request['discount'][$value]]))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }
            if ($request->post('type') == 'extra_sanction') {

                
                $temporale_f = tap(ExtraSanction::where(['staff_id' => $request['staff'][$value], 'extra_type_id' => $request['extra'][$value],'extra_part_id' => $request['extra_part'][$value],'iteration' => $request['iteration'][$value], 'sanction_discount_id' => $request['discount_type'][$value]]))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }
            if ($request->post('type') == 'leave_sanction') {
                // return response()->json(['message' => $request->all()]);
                
                $temporale_f = tap(LeaveSanction::where(['staff_id' => $request['staff'][$value], 'leave_type_id' => $request['leave'][$value],'leave_part_id' => $request['leave_part'][$value],'iteration' => $request['iteration'][$value],'sanction_discount_id' => $request['discount_type'][$value],'discount' => $request['discount'][$value]]))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }


            // $payroll = DB::table('discounts')->where('staff_id',$request['staff'][$value])->sum('quantity');
            // return response()->json(['message' => intval($payroll)]);

            if ($temporale_f->isEmpty()) {

               

             $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            // }
        }




        return response()->json(['message' => $request->all()]);
    }
}
