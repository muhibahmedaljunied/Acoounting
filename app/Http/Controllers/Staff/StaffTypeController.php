<?php

namespace App\Http\Controllers\Staff;
use App\Traits\Staff\BasicData\StoreTrait;
use App\Http\Controllers\Controller;

use App\Models\StaffType;
use DB;
use Illuminate\Http\Request;

class StaffTypeController extends Controller
{

    use StoreTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff_types = DB::table('staff_types')
        ->select('staff_types.*')
        ->paginate(10);
    return response()->json($staff_types);
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
    // public function store(Request $request)
    // {
    //     //
    // }


    /**
     * Display the specified resource.
     *
     * @param  \App\StaffType  $staffType
     * @return \Illuminate\Http\Response
     */
    public function show(StaffType $staffType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffType  $staffType
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffType $staffType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffType  $staffType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffType $staffType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffType  $staffType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffType $staffType)
    {
        //
    }
}
