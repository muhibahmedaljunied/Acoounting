<?php

namespace App\Http\Controllers;

use App\Traits\Staff\StoreTrait;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{

    use StoreTrait;
    public function index()
    {
        
        $staffs = Staff::all();
        $staff_allowances = DB::table('allowances')
        ->join('staff', 'staff.id', '=', 'allowances.staff_id')
        ->join('allowance_types', 'allowances.allowance_type_id', '=', 'allowance_types.id')
        ->select('staff.*', 'allowance_types.name as type','allowances.*')
        ->paginate(10);
      

        $allowance_types = AllowanceType::all();
        return response()->json(['allowance_types' => $allowance_types,'staffs' => $staffs,'staff_allowances' => $staff_allowances]);
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

   






    public function show(Allowance $allowance)
    {
        //
    }


    public function edit(Allowance $allowance)
    {
        //
    }


    public function update(Request $request, Allowance $allowance)
    {
        //
    }


    public function destroy(Allowance $allowance)
    {
        //
    }
}
