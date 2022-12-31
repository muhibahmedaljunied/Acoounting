<?php

namespace App\Http\Controllers;
use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Staff;

class AttendanceController extends Controller

{
     use StoreTrait;

    public function index(Request $request)
    {

        $attendances =  Staff::with([
            'attendance' => function ($query) {
                $query->select('*');
            }

        ])->paginate(10);


        return response()->json(['attendances' => $attendances]);
    }
    // public function store(Request $request)
    // {


    //     // return response()->json($request->all());

    //     foreach ($request->post('count') as $value) {
    //         $temporale_f = 0;
    //         if ($request->post('type') == 'attendance') {

    //             $temporale_f = tap(Attendance::where(['staff_id' => $request['staff'][$value], 'attendance_date' => $request['attendance_date'][$value]]))
    //                 ->update(['attendance_status' => $request->post('status_attendance')[$value], 'check_in' => $request->post('time_in')[$value], 'check_out' => $request->post('time_out')[$value]])
    //                 ->get('id');
    //         }

    //         if (count($temporale_f) == 0) {


    //             $attendance = new Attendance();
    //             $attendance->staff_id =  $request['staff'][$value];
    //             $attendance->attendance_date =  $request['attendance_date'][$value];
    //             $attendance->attendance_status =  $request['status_attendance'][$value];
    //             $attendance->check_in =  $request['time_in'][$value];
    //             $attendance->check_out =  $request['time_out'][$value];
    //             $attendance->save();

    //         }
    //     }

      




    //     return response()->json(['message' => $request->all()]);


        // $attendance_status = 0;
        // if ($request->post('attendance_status') == 'apsence') {
        //     $attendance_status = 0;
        // }
        // if ($request->post('attendance_status') == 'attend') {
        //     $attendance_status = 1;
        // }
        // if ($request->post('attendance_status') == 'permission') {
        //     $attendance_status = 2;
        // }
        // $staff = new Attendance();
        // $staff->staff_id = $request->post('staff_id');
        // $staff->attendance_status = $attendance_status;
        // $staff->attendance_date = $request->post('attendance_date');
        // $staff->check_in = $request->post('check_in');
        // $staff->check_out = $request->post('check_out');
        // $staff->save();




        // return response()->json($request->all());
    // }
}
