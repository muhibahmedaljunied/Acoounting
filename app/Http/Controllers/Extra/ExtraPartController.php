<?php

namespace App\Http\Controllers\Extra;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\Part;
use App\Models\Staff;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Http\Request;

class ExtraPartController extends Controller
{
    use StoreTrait;
    public function index()
    {

    
        $extra_parts = Part::all();
       
        return response()->json(['extra_parts'=>$extra_parts]);
    }


    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['extra','extra.extra_type'])->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
        }

   

}
