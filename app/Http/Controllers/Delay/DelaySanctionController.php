<?php

namespace App\Http\Controllers\Delay;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\CoreStaffService;
use App\Services\Core\HrService;
use App\Models\DelayType;
use App\Models\Part;

use DB;
class DelaySanctionController extends Controller
{


    public function __construct(
        protected HrService $hr,
        protected CoreStaffService $core,

    ) {
    }
    public function index()
    {

       
        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'list' => $this->get_delay_sanction(),
            'delay_types' => DelayType::all(), 
            'delay_parts' => Part::all(), 
            'staffs' => $staffs, 
            'discount_types' => SanctionDiscount::all()
        ]);
    }


       
    public function get_delay_sanction(){

        $delay_sanctions = Cache::rememberForever('delay_sanctions_index', function () {

            return DB::table('delay_sanctions')
                ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                ->select(
                    'delay_sanctions.*', 
                    'delay_types.name as delay', 
                    'parts.name as duration', 
                    'sanction_discounts.name as discount_name'
                )
                ->paginate(10);
        });

        return $delay_sanctions;

    }

           
    public function get_staff_delay_sanction(Request $request){

        $staff = DB::table('staff_sanctions')
        ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
        ->select(
            'staff_sanctions.date as sanction_date',
            'staff_sanctions.sanctionable_type',
            'staff_sanctions.sanctionable_id',
            'staff.name',
            'staff.id'
        )
        ->paginate(100);

        
        foreach ($staff as $value) {

      
            if ($value->sanctionable_type == 'App\\Models\\DelaySanction') {

                $delay = DB::table('delay_sanctions')->where('delay_sanctions.id', $value->sanctionable_id)
                    ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                    ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                    ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
                    ->select(
                        'delay_sanctions.*', 
                    'delay_types.name as type_name',
                    'parts.name as parts_name',
                    'sanction_discounts.name as discount_name'
                    )
                    ->get();


                $value->DelaySanction = $delay;
            }
         
        }

        return response()->json(['list' => $staff]);


    }



    public function store(Request $request)
    {
        $this->core->data = $request->all();
     
        foreach ($request->post('count') as $value) {

            $this->core->value = $value;

            $this->hr->store();

            // }
        }

        Cache::forget('delay_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }


}
