<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\StaffReligion;
use DB;
use Illuminate\Http\Request;

class StaffReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use StoreTrait;
    public function index()
    {
        
        $staff_religions = DB::table('staff_religions')
        ->select('staff_religions.*')
        ->paginate(10);
    return response()->json($staff_religions);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffReligion  $staffReligion
     * @return \Illuminate\Http\Response
     */
    public function show(StaffReligion $staffReligion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffReligion  $staffReligion
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffReligion $staffReligion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffReligion  $staffReligion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffReligion $staffReligion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffReligion  $staffReligion
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffReligion $staffReligion)
    {
        //
    }
}
