<?php

namespace App\Http\Controllers\Delay;
use App\Http\Controllers\Controller;
use App\Traits\Staff\BasicData\StoreTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\DelayType;
use App\Models\Staff;
use App\Models\Delay;
use DB;
class DelayController extends Controller
{
 
    use StoreTrait;
    public function index()
    {
     
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        
        return response()->json(['delay_types'=>DelayType::all(),'staffs'=>$staffs]);
    }

  

  
    public function store(Request $request)
    {
        $absence = new Delay();
        $absence->staff_id = $request->post('staff');
        $absence->delay_type_id = $request->post('delay_type');
        $absence->date = $request->post('date');
        $absence->note = $request->post('note');

        $absence->save();
        return response()->json();
    }

   
}
