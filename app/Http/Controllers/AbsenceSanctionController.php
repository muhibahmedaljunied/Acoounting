<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Http\Request;

class AbsenceSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use StoreTrait;
    public function index()
    {

        $absence_sanctions = DB::table('absence_sanctions')
        ->join('staff','staff.id', '=', 'absence_sanctions.staff_id')
        ->join('absence_types','absence_types.id', '=', 'absence_sanctions.absence_type_id')
        ->join('sanction_discounts','sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
        ->select('staff.name as staff_name','absence_sanctions.*','absence_types.name as absence','sanction_discounts.name as discount_name')
        ->paginate(10);
      


        $absence_types = AbsenceType::all();
        $discount_types = SanctionDiscount::all();
        $staffs = Staff::all();

        return response()->json(['absence_types'=>$absence_types,'staffs'=>$staffs,'discount_types'=>$discount_types,'list'=>$absence_sanctions]);
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
