<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\Absence;
use App\Models\WorkType;
use App\Models\PeriodWorkType;
use App\Models\Rest;
use App\Models\Period;
use App\Models\ProductUnit;
use DB;
use Illuminate\Http\Request;

class WorkSystemController extends Controller
{

    use StoreTrait;
    public function index()
    {


        $work_types = WorkType::all();
        // $breaks = Rest::all();
        $periods = Period::all();
      


        $work_systms = PeriodWorkType::select('*')->get();
        // $work_systms = WorkType::with(['work_types'])->get();

        // $array_data = [];
        foreach ($work_systms as $value) {


            $period = Period::where('id', $value->period_id)->get();
            $value->period = $period;

            $work_type = WorkType::where('id', $value->work_type_id)->get();
            $value->work_type = $work_type;


            $value->days =  json_decode($value->day_id);
        }

        return response()->json(['work_types' => $work_types, 'periods' => $periods, 'work_systems' => $work_systms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    // public function store(Request $request)
    // {
    //     $absence = new Absence();
    //     $absence->staff_id = $request->post('staff');
    //     $absence->absence_type_id = $request->post('absence_type');
    //     $absence->date = $request->post('date');
    //     $absence->note = $request->post('note');

    //     $absence->save();
    //     return response()->json();
    // }


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
