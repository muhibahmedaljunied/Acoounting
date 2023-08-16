<?php

namespace App\Http\Controllers\Extra;

use App\Services\SanctionService;
use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\Part;
use App\Models\SanctionDiscount;
use App\Models\ExtraSanction;
use App\Http\Controllers\Controller;

use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
class ExtraSanctionController extends Controller
{
  
    public function index()
    {


        $extra_sanctions = Cache::rememberForever('extra_sanctions_index',function(){
            
            return DB::table('extra_sanctions')
            ->join('extra_types','extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts','parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts','sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('extra_sanctions.*','parts.name as duration','extra_types.name as extra','sanction_discounts.name as discount_name')
            ->paginate(10);

        });

        $extra_types = ExtraType::all();
        $discount_types = SanctionDiscount::all();

        $extra_parts = Part::all();
         // ------------------------------------------------------------------------------------------------
         $staffs = Cache::rememberForever('staff', function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        return response()->json(['list'=>$extra_sanctions,
                                'extra_types'=>$extra_types,
                                'staffs'=>$staffs,
                                'discount_types'=>$discount_types,
                                'extra_parts'=>$extra_parts]);
    }


    public function store(Request $request,SingleSanctionRepositoryInterface $sanction)
    {
       

        foreach ($request->post('count') as $value) {

            $temporale_f = 0;

            // $temporale_f = $sanction->update($temporale_f,$request,$request->post('type'));
            $temporale_f = $sanction->update($temporale_f,$request);


            if ($temporale_f->isEmpty()) {

                $sanction->add($request->all(),$value);


            }

        }

        Cache::forget('extra_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }

    
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
