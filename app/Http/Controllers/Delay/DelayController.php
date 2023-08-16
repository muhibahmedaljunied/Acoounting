<?php

namespace App\Http\Controllers\Delay;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\Delay;
use App\Models\DelayType;
use App\Models\Staff;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DelayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use StoreTrait;
    public function index()
    {
        // $delays = DB::table('delays')
        // ->join('delay_types','delay_types.id', '=', 'delays.delay_type_id')
        // ->join('staff','staff.id', '=', 'delays.staff_id')
        // ->select('delays.*','delay_types.name as delay','staff.*')
        // ->paginate(10);

        $delay_types = DelayType::all();
        // $staffs = Staff::all();
         // ------------------------------------------------------------------------------------------------
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        
        return response()->json(['delay_types'=>$delay_types,'staffs'=>$staffs]);
    }

    public function create()
    {
        //
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

    public function show(Delay $delay)
    {
        //
    }

    public function edit(Delay $delay)
    {
        //
    }

  
    public function update(Request $request, Delay $delay)
    {
        //
    }

   
    public function destroy(Delay $delay)
    {
        //
    }
}
