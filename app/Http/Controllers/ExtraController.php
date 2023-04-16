<?php

namespace App\Http\Controllers;

use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    use StoreTrait;
    public function index()
    {

        $extras = staff::with(['extra','extra.extra_type'])->paginate(10);



        // $extras = DB::table('extras')
        // ->join('extra_types','extra_types.id', '=', 'extras.extra_type_id')
        // ->join('staff','staff.id', '=', 'extras.staff_id')
        // ->select('extras.*','extra_types.name as extra','staff.*')
        // ->paginate(10);
        $extra_parts = ExtraPart::all();
        $extra_types = ExtraType::all();
        $staffs = Staff::all();
        return response()->json(['extra_types'=>$extra_types,'extra_parts'=>$extra_parts,'staffs'=>$staffs,'list'=>$extras]);
    }


    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['extra','extra.extra_type'])->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
        }

   
    public function create(Request $request)
    {
       
    }

  
    public function show(Extra $extra)
    {
        //
    }

   
    public function edit(Extra $extra)
    {
        //
    }

    public function update(Request $request, Extra $extra)
    {
        //
    }

  
    public function destroy(Extra $extra)
    {
        //
    }
}
