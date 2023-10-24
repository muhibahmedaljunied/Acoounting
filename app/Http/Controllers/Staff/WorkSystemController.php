<?php

namespace App\Http\Controllers\Staff;
use App\Traits\Staff\BasicData\StoreTrait;
use App\Http\Controllers\Controller;
use App\Models\WorkSystemDetail;
use App\Models\WorkSystem;
use App\Models\PeriodTime;
use App\Models\Absence;
use App\Models\WorkType;
use DB;
use Illuminate\Http\Request;

class WorkSystemController extends Controller
{

    use StoreTrait;
    public function index()
    {


        $work_systems = WorkSystem::join('work_system_details', 'work_system_details.work_system_id', '=', 'work_systems.id')
        ->join('work_types', 'work_types.id', '=', 'work_system_details.work_type_id')
        ->join('period_times', 'period_times.id', '=', 'work_system_details.period_time_id')
        ->select(
            'work_systems.name',
            'work_types.name as type',
            'period_times.id as period_id',
            'period_times.*',
            'work_system_details.day_id as days',

        )
        ->paginate(10);

        
        // $work_systms = WorkSystem::select('*')->get();

        // foreach ($work_systms as $value) {


        //     $period = PeriodTime::where('id', $value->period_time_id)->get();
        //     $value->period = $period;

        //     $work_type = WorkType::where('id', $value->work_type_id)->get();
        //     $value->work_type = $work_type;


        //     $value->days =  json_decode($value->day_id);
        // }

        return response()->json([
            'work_types' => WorkType::all(),
            'periods' => PeriodTime::all(),
            'work_systems' => $work_systems
        ]);
    }

   
    public function create()
    {
        //
    }


    public function store(Request $request)
    {


        $work_systm = new WorkSystem();

        $work_systm->name = $request->post('name');
        // $absence->work_type_id = $request->post('work_type');
        
        $work_systm->save();

        foreach ($request->post('count') as $value) {


            $absence = new WorkSystemDetail();
            $absence->work_system_id = $work_systm->id;
            $absence->work_type_id = $request->post('work_type');
            $absence->period_time_id = $request->post('period')[$value];
            $absence->day_id = json_encode($request->post('day')[$value]);

            $absence->save();
        }
        return response()->json();
    }


    public function show(Absence $absence)
    {
        //
    }


    public function edit(Absence $absence)
    {
        //
    }


    public function update(Request $request, Absence $absence)
    {
        //
    }


    public function destroy(Absence $absence)
    {
        //
    }
}
