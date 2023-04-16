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
        

        $advances = staff::with(['advance'])->paginate(10);
        $staffs = Staff::all();
        return response()->json(['staffs'=>$staffs,'list'=>$advances]);
    }

    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['advance'])->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
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
