<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Models\ExtraSanction;
// use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ExtraSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use StoreTrait;
    public function index()
    {


        $extra_sanctions = Cache::rememberForever('extra_sanctions_index',function(){
            
            return DB::table('extra_sanctions')
            ->join('staff','staff.id', '=', 'extra_sanctions.staff_id')
            ->join('extra_types','extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('extra_parts','extra_parts.id', '=', 'extra_sanctions.extra_type_id')
            ->join('sanction_discounts','sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('staff.name as staff_name','extra_sanctions.*','extra_parts.name as duration','extra_types.name as extra','sanction_discounts.name as discount_name')
            ->paginate(10);

        });

        

        $extra_types = ExtraType::all();
        $discount_types = SanctionDiscount::all();

        $extra_parts = ExtraPart::all();
         // ------------------------------------------------------------------------------------------------
         $staffs = Cache::rememberForever('staff', function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        return response()->json(['list'=>$extra_sanctions,'extra_types'=>$extra_types,'staffs'=>$staffs,'discount_types'=>$discount_types,'extra_parts'=>$extra_parts]);
    }


    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;

            if ($request->post('type') == 'extra_sanction') {

                $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
                    ->update(['sanctions' => $request['sanction']])
                    ->get('id');
            }
            
            if ($temporale_f->isEmpty()) {

                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
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


  
    public function show(Extra $absence)
    {
        //
    }


    public function edit(Extra $absence)
    {
        //
    }

 
    public function update(Request $request, Extra $absence)
    {
        //
    }


    public function destroy(Extra $absence)
    {
        //
    }
}
