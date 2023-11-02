<?php

namespace App\Http\Controllers\Staff;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Http\Controllers\Controller;
use App\Models\PeriodTime;
use App\Models\Absence;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{

    use StoreTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $periods = period::all();


        // $periods = DB::table('periods')
        //         ->join('work_types', 'work_types.id', '=', 'periods.work_type_id')
        //         ->select('periods.*', 'work_types.name as type')
        //         ->get();


        // $periods = Period::all();


        return response()->json(['periods' => period::all()]);
    }

    public function get_period_time(Request $request)
    {

        $period_times = PeriodTime::join('periods', 'periods.id', '=', 'period_times.period_id')
            ->select(
                'periods.name as period_name',
                'period_times.*',
                'periods.id as period_id',
            )
            ->get();

        return response()->json(
            [
                'period_times' => $period_times,
                'periods' => period::all()
            ]
        );
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_period(Request $request)
    {

        // dd($request->all());

        foreach ($request->post('count') as $value) {

            $absence = new Period();

            $absence->name = $request->post('type')[$value];
        
            $absence->save();
        }
        return response()->json();
    }

    public function store_period_time(Request $request)
    {

        // dd($request->all());

        foreach ($request->post('count') as $value) {

            $absence = new PeriodTime();

            $absence->period_id = $request->post('type')[$value];
            $absence->from_time = $request->post('from_period')[$value];
            $absence->into_time = $request->post('into_period')[$value];
            $absence->duration = $request->post('duration_period')[$value];

            $absence->save();
        }
        return response()->json();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(Absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        //
    }
}
