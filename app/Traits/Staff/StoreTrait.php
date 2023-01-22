<?php

namespace App\Traits\Staff;

use App\Models\Attendance;
use App\Models\Extra;
use App\Models\Discount;
use App\Models\Advance;
use App\Models\Allowance;
use App\Models\Payroll;
use App\Models\Vacation;
use App\Traits\Staff\TemporaleTrait;
use Illuminate\Http\Request;
use DB;

trait StoreTrait
{

    use TemporaleTrait;

    public function store(Request $request)
    {

        // return response()->json(['message' => $request->all()]);
        foreach ($request->post('count') as $value) {





            $temporale_f = 0;
            // if ($value !== null) {
            if ($request->post('type') == 'attendance') {

                $temporale_f = tap(Attendance::where(['staff_id' => $request['staff'][$value], 'attendance_date' => $request['attendance_date'][$value]]))
                    ->update(['attendance_status' => $request->post('status_attendance')[$value], 'check_in' => $request->post('time_in')[$value], 'check_out' => $request->post('time_out')[$value]])
                    ->get('id');
            }
            if ($request->post('type') == 'extra') {

                $date1 = $request['start_time'][$value];
                $date2 = $request['end_time'][$value];
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hour = abs($timestamp2 - $timestamp1) / (60 * 60) . " hour(s)";
                $quantity = intval($hour)*intval(1000);


        
                // return response()->json(['message' => intval($hour)]);

                
                $temporale_f = tap(Extra::where(['staff_id' => $request['staff'][$value], 'extra_type_id' => $request['extra_type'][$value]]))
                    ->update(['start_date' => $request['start_date'][$value], 'end_date' => $request['end_date'][$value], 'start_time' => $request['start_time'][$value], 'end_time' => $request['end_time'][$value],'number_hours' => $hour,'quantity' => $quantity])
                    ->get('id');
                // $this->refresh_payroll($request->all(), $request->post('type'));
            }

            if ($request->post('type') == 'discount') {

                $temporale_f = tap(Discount::where(['staff_id' => $request['staff'][$value], 'discount_type_id' => $request['discount_type'][$value], 'date' => $request['date'][$value]]))
                    ->update(['quantity' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            if ($request->post('type') == 'allowance') {

                $temporale_f = tap(Allowance::where(['staff_id' => $request['staff'][$value], 'allowance_type_id' => $request['allowance_type'][$value]]))
                    ->update(['qty' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }


            if ($request->post('type') == 'advance') {
                // return response()->json(['message' => $request->all()]);

                $temporale_f = tap(Advance::where(['staff_id' => $request['staff'][$value]]))
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
            // $payroll = DB::table('discounts')->where('staff_id',$request['staff'][$value])->sum('quantity');
            // return response()->json(['message' => intval($payroll)]);

            if (count($temporale_f) == 0) {

               

                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            // }
        }




        return response()->json(['message' => $request->all()]);
    }
}
