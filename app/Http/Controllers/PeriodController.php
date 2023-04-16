<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Period;
use App\Models\AbsenceType;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $extras = staff::with(['extra','extra.extra_type'])->paginate(10);



        // $extras = DB::table('extras')
        // ->join('extra_types','extra_types.id', '=', 'extras.extra_type_id')
        // ->join('staff','staff.id', '=', 'extras.staff_id')
        // ->select('extras.*','extra_types.name as extra','staff.*')
        // ->paginate(10);
      


        $periods = Period::all();
     

        return response()->json(['periods'=>$periods]);
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
    public function store(Request $request)
    {
        $absence = new Absence();
        $absence->staff_id = $request->post('staff');
        $absence->absence_type_id = $request->post('absence_type');
        $absence->date = $request->post('date');
        $absence->note = $request->post('note');

        $absence->save();
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
