<?php

namespace App\Http\Controllers;
use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use App\Models\Advance;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
   use StoreTrait;
    public function index()
    {
         $advances = DB::table('advances')
        ->join('staff','staff.id', '=', 'advances.staff_id')
        ->select('advances.*','staff.*')
        ->paginate(10);

    
        $staffs = Staff::all();
        return response()->json(['staffs'=>$staffs,'advances'=>$advances]);
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


    public function show(Advance $advance)
    {
        //
    }

  
    public function edit(Advance $advance)
    {
        //
    }


    public function update(Request $request, Advance $advance)
    {
        //
    }

    public function destroy(Advance $advance)
    {
        //
    }
}
