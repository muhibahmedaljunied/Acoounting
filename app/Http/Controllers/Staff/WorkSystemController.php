<?php

namespace App\Http\Controllers\Staff;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Http\Controllers\Controller;
use App\Models\WorkSystemDetail;
use App\Models\WorkSystem;
use App\Models\PeriodTime;
use App\Models\Absence;
use App\Models\Period;
use App\Models\WorkSystemType;
use App\Models\WorkType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WorkSystemController extends Controller
{

    use StoreTrait;
    public function index()
    {


        $work_systems = WorkSystem::join('work_system_details', 'work_system_details.work_system_id', '=', 'work_systems.id')
            ->join('period_times', 'period_times.id', '=', 'work_system_details.period_time_id')
            ->join('work_system_types', 'work_systems.work_system_type_id', '=', 'work_system_types.id')
            ->join('work_types', 'work_types.id', '=', 'work_system_types.work_type_id')

            ->select(
                'work_systems.*',
                'work_types.name as wokr_type_name',
                'work_system_types.name as work_system_type_name',
                'period_times.id as period_id',
                'period_times.*',
                'work_system_details.day_id as days',

            )
            ->paginate(10);


        // dd($work_systems);
        return response()->json([
            'work_system_types' => WorkSystemType::all(),
            'period_times' => PeriodTime::all(),
            'periods' => Period::all(),
            'work_systems' => $work_systems
        ]);
    }

    public function get_period_time($id)
    {


        $period_times = PeriodTime::where('period_times.period_id', $id)
            ->join('periods', 'periods.id', '=', 'period_times.period_id')
            ->select(
                'period_times.*',

            )
            ->get();

        return response()->json([
            'period_times' => $period_times,
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {



        try {

            DB::beginTransaction();

            $work_systm  = WorkSystem::updateOrCreate(
                [
                    'work_system_type_id'   => $request->post('work_system_type'),
                ]
            );


            foreach ($request->post('count') as $value) {


                WorkSystemDetail::updateOrCreate(
                    [
                        'work_system_id' => $work_systm->id,
                        'period_time_id' => $request->post('period')[$value],
                        'day_id' => json_encode($request->post('day')[$value]),
                        'sort_period' => $request->post('sort_period')[$value],

                    ]
                );
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

        return response()->json(['message' => $request->all()]);
    }




   
}
