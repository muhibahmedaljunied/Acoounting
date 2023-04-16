<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeavePart;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Http\Request;

class LeaveSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use StoreTrait;
    public function index()
    {
       



        $leave_sanctions = DB::table('leave_sanctions')
        ->join('staff','staff.id', '=', 'leave_sanctions.staff_id')
        ->join('leave_types','leave_types.id', '=', 'leave_sanctions.leave_type_id')
        ->join('leave_parts','leave_parts.id', '=', 'leave_sanctions.leave_part_id')
        ->join('sanction_discounts','sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
        ->select('staff.name as staff_name','leave_sanctions.*','leave_types.name as leave','leave_parts.name as duration','sanction_discounts.name as discount_name')
        ->paginate(10);
      


        $leave_types = LeaveType::all();
        $leave_parts = LeavePart::all();
        $discount_types = SanctionDiscount::all();
        $staffs = Staff::all();

        return response()->json(['list'=>$leave_sanctions,'leave_types'=>$leave_types,'staffs'=>$staffs,'discount_types'=>$discount_types,'leave_parts'=>$leave_parts]);
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
    //     $absence = new Leave();
    //     $absence->staff_id = $request->post('staff');
    //     $absence->leave_type_id = $request->post('leave_type');
    //     $absence->date = $request->post('date');
    //     $absence->note = $request->post('note');

    //     $absence->save();
    //     return response()->json();
    // }

  
    public function show(Leave $absence)
    {
        //
    }


    public function edit(Leave $absence)
    {
        //
    }

 
    public function update(Request $request, Leave $absence)
    {
        //
    }


    public function destroy(Leave $absence)
    {
        //
    }
}
