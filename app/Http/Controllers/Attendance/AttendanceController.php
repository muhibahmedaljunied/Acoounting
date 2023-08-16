<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Services\AttendanceService;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Models\Staff;
use App\Models\OfficialHoliday;
use App\Models\WorkType;
use App\Models\PeriodWorkType;
use App\Traits\Details\DetailsTrait;
use App\Http\Controllers\Controller;
use App\Models\AttendanceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AttendanceController extends Controller

{
    use DetailsTrait;


    public function __construct(
        protected AttendanceService $service,
        protected DetailRepositoryInterface $details
    ) {
        $this->service = $service;
        $this->details = $details;
    }


    public function index(Request $request)
    {

        $attendances =  Staff::with([
            'attendance' => function ($query) {
                $query->select('*');
            }
        ])->paginate(10);
        $official_holidays = OfficialHoliday::all();
        // ------------------------------------------------------------------------------------------------
        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json(['list' => $attendances, 'staffs' => $staffs, 'official_holidays' => $official_holidays]);
    }

    public function report(Request $request)
    {

        $staffs = Staff::all();
        $work_systems = WorkType::all();
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



        $periods = PeriodWorkType::where('period_work_types.work_type_id', $request->id)
            ->join('work_types', 'work_types.id', '=', 'period_work_types.work_type_id')
            ->join('periods', 'periods.id', '=', 'period_work_types.period_id')
            ->select('periods.*', 'periods.id as period_id', 'periods.name as period_name', 'work_types.*')
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

    public function get_time(Request $request)
    {



        // ----------------------------------------------------------------
        
        $period = DB::table('attendances')->where([
            'attendances.attendance_date' => $request['date']
        ])
            ->join('staff', 'staff.id', '=', 'attendances.staff_id')
            ->select('staff.id as staff_id', 'staff.name', 'attendances.*')
            ->paginate(10);

        foreach ($period as $key => $value) {

            if ($value->attendance_status == 1) {

                $periods = DB::table('attendance_details')->where([
                    'attendance_details.period_id' => $request->id,
                    'attendance_details.attendance_id' => $value->id,
                ])
                    ->select('attendance_details.*')
                    ->get();

                $value->details = $periods;
            }
        }
        return response()->json(['periods' => $period]);
    }

    public function store(Request $request)
    {


        // return response([
        //     'message' => $request->all(),

        // ]);

    
        try {

            DB::beginTransaction();
            foreach ($request->post('count') as $value) {

                if ($request['attendance_status'][$value] == 1) {

                    $this->service->attende($request, $value);
                } else {
                    $this->service->absence($request, $value);
                }
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
}
