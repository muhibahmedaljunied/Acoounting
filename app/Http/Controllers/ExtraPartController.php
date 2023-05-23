<?php

namespace App\Http\Controllers;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class ExtraPartController extends Controller
{
    use StoreTrait;
    public function index()
    {

    
        $extra_parts = ExtraPart::all();
       
        return response()->json(['extra_parts'=>$extra_parts]);
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
