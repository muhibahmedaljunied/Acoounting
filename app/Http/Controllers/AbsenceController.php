<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use DB;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function test()
 {
           event(new TestEvent('One Click'));
     return response()->json(['absence_types'=>'Hooray!!! You have fired your Event successfully']);

 }


    public function index()
    {
        
        $absence_types = AbsenceType::all();
        $discount_types = SanctionDiscount::all();
        $staffs = Staff::all();

        return response()->json(['absence_types'=>$absence_types,'staffs'=>$staffs,'discount_types'=>$discount_types]);
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
