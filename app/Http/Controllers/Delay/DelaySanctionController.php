<?php

namespace App\Http\Controllers\Delay;
use App\Services\SanctionService;
use App\Models\Delay;
use App\Models\DelayType;
use App\Models\Part;
use App\Models\SanctionDiscount;
use App\Http\Controllers\Controller;

use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DelaySanctionController extends Controller
{
 
    public function index()
    {

        $delay_sanctions = Cache::rememberForever('delay_sanctions_index',function(){
            
            return DB::table('delay_sanctions')
            ->join('delay_types','delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts','parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts','sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select('delay_sanctions.*','delay_types.name as delay','parts.name as duration','sanction_discounts.name as discount_name')
            ->paginate(10);

        });

        $delay_types = DelayType::all();
        $delay_parts = Part::all();
        $discount_types = SanctionDiscount::all();
         // ------------------------------------------------------------------------------------------------
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        return response()->json(['list'=>$delay_sanctions,'delay_types'=>$delay_types,'delay_parts'=>$delay_parts,'staffs'=>$staffs,'discount_types'=>$discount_types]);
    }


    public function store(Request $request,SingleSanctionRepositoryInterface $sanction)
    {

        // return response()->json(['message' => $request->all()]);
        foreach ($request->post('count') as $value) {


            $temporale_f = 0;
            $temporale_f = $sanction->update($temporale_f,$request);

            if ($temporale_f->isEmpty()) {

                $sanction->add($request->all(),$value);
       
            }
            // }
        }

        Cache::forget('delay_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }
  
    public function create()
    {
        //
    }



  
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
