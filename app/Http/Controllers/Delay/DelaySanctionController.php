<?php

namespace App\Http\Controllers\Delay;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DelaySanction;
use Illuminate\Support\Facades\Cache;
use App\Services\CoreStaffService;
use App\Repository\HR\DelaySanctionRepository;
use App\Models\DelayType;
use App\Models\Part;
use App\Models\StaffSanction;
use App\Repository\StaffSaction\StaffDelaySanctionRepository;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;

class DelaySanctionController extends Controller
{


    public function __construct(
        protected DelaySanctionRepository $hr,
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



    public function get_delay_sanction()
    {

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


    public function get_staff_delay_sanction(Request $request)
    {


        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                DelaySanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id');
                    $query->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id');
                    $query->join('parts', 'parts.id', '=', 'delay_sanctions.part_id');
                    $query->select(
                        'delay_sanctions.*',
                        'delay_types.name as type_name',
                        'parts.name as part_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
                ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')

           
            ->where('sanctionable_type', 'App\\Models\\DelaySanction')
            ->select(
                'staff_sanctions.date as sanction_date',
                'staff_sanctions.sanctionable_type',
                'staff_sanctions.sanctionable_id',
                'staff.name',
                'staff.id',
                'staff_sanctions.status'

            )
            ->paginate();

        return response()->json(['list' => $staff]);
    }
   

    public function store(Request $request)
    {
        $this->core->data = $request->all();

        foreach ($request->post('count') as $value) {

            $this->core->value = $value;

            $this->hr->handle();

            // }
        }

        Cache::forget('delay_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }

    public function change_status(
        Request $request,
        StaffDelaySanctionRepository $staff_sanction,
        PayrollService $payroll
        )
    {

        // dd($request->all());
        $this->core->data = $request->all();
   
        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();
    
            $payroll->payroll('total_delay_sanction');
  
    

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Delay Created Successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
}



            // tap(StaffSanction::where([
            //     'staff_id' => $request->staff,
            //     'sanctionable_id' => $request->sanctionable_id,
            //     'sanctionable_type' => $request->sanctionable_type,
            //     'date' => $request->date


            // ]))
            //     ->update(['status' => $request->status])
            //     ->get('id');