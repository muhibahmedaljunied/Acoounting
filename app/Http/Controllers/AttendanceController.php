<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\WorkPeriod;
use App\Models\Staff;
use App\Models\WorkType;
use App\Models\AttendanceDetail;
use App\Traits\Details\DetailsTrait;
use DB;
use Illuminate\Support\Facades\Cache;
class AttendanceController extends Controller

{
    use DetailsTrait;
    public function index(Request $request)
    {

        $attendances =  Staff::with([
            'attendance' => function ($query) {
                $query->select('*');
            }

        ])->paginate(10);

        $staffs = Staff::all();
         // ------------------------------------------------------------------------------------------------
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        
        return response()->json(['list' => $attendances, 'staffs' => $staffs]);
    }

    public function report(Request $request)
    {

        $staffs = Staff::all();
        $work_systems = WorkType::all();
        // $attenances = Attendance::join('attendance_details','attendance_details.attendance_id', '=', 'attendances.id')
        // ->select('attendances.*','attendance_details.*')
        // ->get();


        $attenances = Cache::rememberForever('attenances', function () {
            return Attendance::with([

                'attendance_details' => function ($query) {
                    $query->select('*');
                }
    
            ])->paginate(10);
    
        });

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




        $attendances =  Attendance::where(["attendances.staff_id" => $request->post('staff')])->whereBetween('attendances.attendance_date', array($request->post('from_date'), $request->post('into_date')))
            ->with([
                'attendance_details' => function ($query) use ($request) {
                    $query->where(["attendance_details.period_id" => $request->post('period')])->select('*');
                },
                'staff' => function ($query) {
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

            foreach ($value->attendance_details as $attenances) {


                $total_delay  = $total_delay + $attenances->delay;
                $total_leave  = $total_leave + $attenances->leave;

                if ($attenances->attendance_status == 0) {

                    $total_apsence  = $total_apsence + $attenances->apsence;
                } else {
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

    public function store(Request $request)
    {

        // return response()->json($request->all());

        foreach ($request->post('count') as $value) {


            if ($request['attendance_in_out'] == 1) {

                $updating_data = ['attendance_status' => $request->post('attendance_status')[$value], 
                                 'check_in' => $request->post('time_in')[$value]];
            } else {

                $updating_data = ['attendance_status' => $request->post('attendance_status')[$value], 
                                  'check_out' => $request->post('time_out')[$value]];
            }


            $attendance_id = Attendance::whereAttendance($request)
                ->select('attendances.id')
                ->get();


            if ($attendance_id->isEmpty()) {

                $attendance_id = $this->add($request->all(), $value, $request->post('type'));

                // $this->init_details(id: $attendance_id,value: $value,type: $request->post('type'),data: $request->all());
                $this->init_details(id:$attendance_id,value:$value,type:$request->post('type'),data:$request->all());

            } else {

                foreach ($attendance_id as $values) {

                    $attendance_id = $values['id'];
                }

                $temporale_f = tap(AttendanceDetail::where([
                    'attendance_id' => $attendance_id,
                    'period_id' => $request['period']
                ]))
                    ->update($updating_data)
                    ->get('id');

                if ($temporale_f->isEmpty()) {

                    $this->init_details(id:$attendance_id,value:$value,type:$request->post('type'),data:$request->all());


                }
            }
        }

        return response()->json($request->all());
    }
}
