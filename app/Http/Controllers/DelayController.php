<?php

namespace App\Http\Controllers;

use App\Models\Delay;
use App\Models\DelayType;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class DelayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $delays = DB::table('delays')
        // ->join('delay_types','delay_types.id', '=', 'delays.delay_type_id')
        // ->join('staff','staff.id', '=', 'delays.staff_id')
        // ->select('delays.*','delay_types.name as delay','staff.*')
        // ->paginate(10);

        $delay_types = DelayType::all();
        $staffs = Staff::all();
        return response()->json(['delay_types'=>$delay_types,'staffs'=>$staffs]);
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
        $absence = new Delay();
        $absence->staff_id = $request->post('staff');
        $absence->delay_type_id = $request->post('delay_type');
        $absence->date = $request->post('date');
        $absence->note = $request->post('note');

        $absence->save();
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delay  $delay
     * @return \Illuminate\Http\Response
     */
    public function show(Delay $delay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delay  $delay
     * @return \Illuminate\Http\Response
     */
    public function edit(Delay $delay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delay  $delay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delay $delay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delay  $delay
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delay $delay)
    {
        //
    }
}
