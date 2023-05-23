<?php

namespace App\Http\Controllers;

use App\Models\Delay;
use App\Models\DelayType;
use App\Models\DelayPart;
use App\Models\Staff;
use App\Models\DelaySanction;
use App\Models\SanctionDiscount;

// use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DelaySanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use StoreTrait;
    public function index()
    {


        $delay_sanctions = Cache::rememberForever('delay_sanctions_index',function(){
            
            return DB::table('delay_sanctions')
            ->join('staff','staff.id', '=', 'delay_sanctions.staff_id')
            ->join('delay_types','delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('delay_parts','delay_parts.id', '=', 'delay_sanctions.delay_type_id')
            ->join('sanction_discounts','sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select('staff.name as staff_name','delay_sanctions.*','delay_types.name as delay','delay_parts.name as duration','sanction_discounts.name as discount_name')
            ->paginate(10);

        });

        


        $delay_types = DelayType::all();
        $delay_parts = DelayPart::all();
        $discount_types = SanctionDiscount::all();
         // ------------------------------------------------------------------------------------------------
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        return response()->json(['list'=>$delay_sanctions,'delay_types'=>$delay_types,'delay_parts'=>$delay_parts,'staffs'=>$staffs,'discount_types'=>$discount_types]);
    }


    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;
            if ($request->post('type') == 'delay_sanction') {

                $temporale_f = tap(DelaySanction::whereDelaySanction($request))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }
          
            if ($temporale_f->isEmpty()) {

                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            // }
        }




        return response()->json(['message' => $request->all()]);
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
    //     $absence = new Delay();
    //     $absence->staff_id = $request->post('staff');
    //     $absence->delay_type_id = $request->post('delay_type');
    //     $absence->date = $request->post('date');
    //     $absence->note = $request->post('note');

    //     $absence->save();
    //     return response()->json();
    // }

  
    public function show(Delay $absence)
    {
        //
    }


    public function edit(Delay $absence)
    {
        //
    }

 
    public function update(Request $request, Delay $absence)
    {
        //
    }


    public function destroy(Delay $absence)
    {
        //
    }
}
