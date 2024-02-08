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
use DB;
use Illuminate\Http\Request;

class WorkSystemTypeController extends Controller
{

    use StoreTrait;
    public function index()
    {


        $work_system_types = WorkSystemType::join('work_types','work_types.id', '=', 'work_system_types.work_type_id')
        ->select(
            'work_system_types.name as work_system_types_name',
            'work_system_types.work_type_id',
            'work_types.*'
        )
        ->paginate(10);

   

        return response()->json([
            'work_types' => WorkType::all(),
            'work_system_types' => $work_system_types
        ]);
        
        
    }

  
    public function store(Request $request)
    {




        // dd($request->all());
    foreach ($request->post('count') as $value) {

        $work_systm = new WorkSystemType();
        $work_systm->name = $request->post('name')[$value];
        $work_systm->work_type_id = $request->post('work_type')[$value];
        $work_systm->save();
    }
        response()->json();
    }
   
    public function create()
    {
        //
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
