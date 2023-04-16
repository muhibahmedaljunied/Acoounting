<?php

namespace App\Http\Controllers;

use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\WorkPeriod;
use App\Models\Period;
use App\Models\Staff;
use App\Models\WorkType;

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

        $staffs = Staff::all();
        return response()->json(['list' => $attendances, 'staffs' => $staffs]);
    }

    public function report(Request $request)
    {

        $staffs = Staff::all();
        $work_systems = WorkType::all();
        // $attenances = Attendance::join('attendance_details','attendance_details.attendance_id', '=', 'attendances.id')
        // ->select('attendances.*','attendance_details.*')
        // ->get();

        $attenances =  Attendance::with([
            
            'attendance_details' => function ($query) {
                $query->select('*');
            }

        ])->paginate(10);

        // $total_delay = 0;
        // $total_leave = 0;
        // $total_apsence = 0;
        // $total_present = 0;

        // foreach ($attenances as $value) {

            

        //     foreach ($value->attendance_details as $attenances) {


        //         $total_delay  = $total_delay + $attenances->delay;
        //         $total_leave  = $total_leave + $attenances->leave;
        //         if($attenances->attendance_status == 0){

        //             $total_apsence  = $total_apsence + $attenances->apsence;
                  
        //         }else{
        //             $total_present  = $total_present + $attenances->present;
                
        //         }
              
         
        //     }
        //     $value->total_delay  = $total_delay;
        //     $value->total_leave  = $total_leave;
        //     $value->total_apsence  = $total_apsence;
        //     $value->total_present  = $total_present;



        // }


        return response()->json(['staffs' => $staffs, 'list' => $attenances, 'work_systems' => $work_systems]);
    }
    public function get_period(Request $request)
    {


        $periods = WorkPeriod::where('work_periods.work_system_id', $request->id)
            ->join('periods', 'periods.id', '=', 'work_periods.period_id')
            ->select('periods.*')
            ->get();


        $staffs = staff::where('staff.work_type_id', $request->id)
            ->select('staff.*')
            ->get();



        return response()->json(['periods' => $periods, 'staffs' => $staffs]);
    }

    public function search(Request $request)
    {


        
        $all = array();

        // if ($request->post('work_system') != 0) {
        //     $s1 = ["attendances.work_id", $request->post('work_id')];
        //     $all[0] = $s1;
        // }

        if ($request->post('period') != 0) {
            $s1 = ["attendance_details.period_id", $request->post('period')];
            $all[0] = $s1;
        }


        if ($request->post('staff') != 0) {

            $s2 = ["attendances.staff_id", $request->post('staff')];
            $all[1] = $s2;
        }

     


        $attendances =  Attendance::where(["attendances.staff_id"=> $request->post('staff')])->
        whereBetween('attendances.attendance_date', array($request->post('from_date'), $request->post('into_date')))
        ->with([
            'attendance_details' => function ($query) use ($request) {
                $query->where(["attendance_details.period_id"=>$request->post('period')])->select('*');
            },
            'staff' => function ($query){
                $query->select('*');
            }
        ])
            ->paginate(10);


        $total_delay =  0;
        $total_leave =   0;
        $total_apsence = 0;
        $total_present = 0;
    
        

        foreach ($attendances as $value) {

            $day = $value->attendance_date;
            $date = strtotime($day);
            $date = date('l', $date);
            $day = $date;

            foreach ($value->attendance_details as $attenances ) {


                $total_delay  = $total_delay + $attenances->delay;
                $total_leave  = $total_leave + $attenances->leave;
              
                if($attenances->attendance_status == 0){

                    $total_apsence  = $total_apsence + $attenances->apsence;
                  
                }else{
                    $total_present  = $total_present + $attenances->present;
                
                }
              
         
            }
         

            $value->total_delay  = $total_delay;
            $value->total_leave  = $total_leave;
            $value->total_apsence  = $total_apsence;
            $value->total_present  = $total_present;
            $value->date  = $date;
   



        }


        return response()->json(['attendances' => $attendances]);
    }

    public function select_staff(Request $request)
    {

        $staffs =  Staff::where('id', $request->id)->with([
            'attendance' => function ($query) {
                $query->select('*');
            }

        ])->paginate(10);

        return response()->json(['list' => $staffs]);
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
