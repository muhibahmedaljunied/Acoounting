<?php

namespace App\Http\Controllers\Absence;

use App\Events\TestEvent;
use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\SanctionDiscount;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function test()
    {
        // return 111;
        event(new TestEvent('One Click'));
        return response()->json(['absence_types' => 'Hooray!!! You have fired your Event successfully']);
    }


    public function index()
    {

        $absence_types = AbsenceType::all();
        $discount_types = SanctionDiscount::all();
         // ------------------------------------------------------------------------------------------------
         $staffs = Cache::rememberForever('staff', function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        return response()->json(['absence_types' => $absence_types, 'staffs' => $staffs, 'discount_types' => $discount_types]);
    }

  
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $absence = new Absence();
        $absence->staff_id = $request->post('staff');
        $absence->absence_type_id = $request->post('absence_type');
        $absence->date = $request->post('date');
        $absence->note = $request->post('note');
        $absence->save();
        return response()->json();
    }


}
