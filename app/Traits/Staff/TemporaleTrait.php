<?php

namespace App\Traits\Staff;

use App\Models\Advance;
use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Extra;
use App\Models\Discount;
use App\Models\Payroll;
use App\Models\Vacation;
use DB;

trait TemporaleTrait
{

    function add($request, $value, $type)
    {
        switch ($type) {


            case 'attendance':
                $temporale = new Attendance();
                $temporale->staff_id =  $request['staff'][$value];
                $temporale->attendance_date = $request['attendance_date'][$value];
                $temporale->attendance_status =  $request['status_attendance'][$value];
                $temporale->check_in =  $request['time_in'][$value];
                $temporale->check_out =  $request['time_out'][$value];
                break;

            case 'extra':
                $date1 = $request['start_time'][$value];
                $date2 = $request['end_time'][$value];
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hour = abs($timestamp2 - $timestamp1) / (60 * 60) . " hour(s)";
                $quantity = intval($hour)*intval(1000);
                // -----------------------------------------------------------------------------------------------------------
                $temporale = new Extra();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->extra_type_id = $request['extra_type'][$value];
                $temporale->start_date = $request['start_date'][$value];
                $temporale->end_date = $request['end_date'][$value];
                $temporale->start_time = $request['start_time'][$value];
                $temporale->end_time = $request['end_time'][$value];
                $temporale->number_hours = intval($hour);
                $temporale->quantity = $quantity;
                // $temporale->note = $request['note'][$value];
                break;
            case 'discount':
                $temporale = new Discount();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->discount_type_id = $request['discount_type'][$value];
                $temporale->quantity = $request['qty'][$value];
                $temporale->date = $request['date'][$value];
                break;

            case 'allowance':
                $temporale = new Allowance();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->name = $request['allow'][$value];
                $temporale->allowance_type_id = $request['allowance_type'][$value];
                $temporale->qty = $request['qty'][$value];
                // $temporale->date = $request['date'][$value];
                break;
            case 'advance':
                $temporale = new Advance();
                $temporale->staff_id = $request['staff'][$value];
                // $temporale->extra_type_id = $request->post('extra_type')[$value];
                $temporale->date = $request['date'][$value];
                $temporale->quantity = $request['qty'][$value];
                break;
            case 'leave':
                $temporale = new Vacation();
                $temporale->staff_id = $request['staff'][$value];
                $temporale->vacation_type_id = $request['leave_type'][$value];
                $temporale->start_date = $request['start_date'][$value];
                $temporale->end_date = $request['end_date'][$value];
                $temporale->total_days = $request['days'];
                // $temporale->total_days = $request->post('days')[$value];
                break;
        }


        $temporale->save();
    }

    function refresh_payroll($request, $value, $type)
    {



        switch ($type) {
            case 'discount':

                $payroll = DB::table('discounts')->where('staff_id', $request['staff'][$value])->sum('quantity');
                $data = ['total_discount' =>$payroll];

                break;
            case 'extra':

                $payroll = DB::table('extras')->where('staff_id', $request['staff'][$value])->sum('quantity');
                $data = ['total_extra' => $payroll];
                break;

            case 'advance':
                $payroll = DB::table('advances')->where('staff_id', $request['staff'][$value])->sum('quantity');
                $data = ['total_advance' => $payroll];
                break;

            case 'allowance':
                $payroll = DB::table('allowances')->where('staff_id', $request['staff'][$value])->sum('qty');
                $data = ['total_allowance' => $payroll];
                break;    
            default:
                return;
        }

        $payroll = tap(Payroll::where(['staff_id' => $request['staff'][$value]]))
            ->update($data)
            ->get('id');

    }
}
