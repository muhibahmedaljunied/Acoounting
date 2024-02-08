<?php

namespace App\Http\Controllers\Delay;

use App\Http\Controllers\Controller;
use App\Services\Staff\DelayService;
use App\Models\DelayType;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\DelayRepository;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
use App\Models\Part;
use App\Models\Staff;
use Illuminate\Http\Request;

class DelayController extends Controller
{

    public function __construct(

        protected CoreStaffService $core,
        protected DelayService $delay_sanction,
        protected DelayRepository $hr,



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
            'delay_types' => DelayType::all(),
            'staffs' => $staffs
        ]);
    }


    public function get_staff_delay()
    {

        // $minutes = 60;
        // $staffs = Cache::remember('staff', $minutes, function () {
            $staffs =  DB::table('delays')
            ->join('delay_types', 'delay_types.id', '=', 'delays.delay_type_id')
            ->join('staff', 'staff.id', '=', 'delays.staff_id')
            ->join('parts', 'parts.id', '=', 'delays.part_id')
            ->select(
                'staff.name as staff_name',
                'staff.id as staff_id',
                'delays.id as delay_id',
                'delays.date',
                'parts.name as part_name',
                'delay_types.name as delay_type_name',

                )
            ->paginate();
        // });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'delay_types' => DelayType::all(),
            'delay_parts' => Part::all(),
            'staffs'=>Staff::all(),
            'list' => $staffs
        ]);
    }

   
    public function store(Request $request)
    {

        // dd($request->all());
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();
            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);

                $this->hr->store();

                $this->delay_sanction->create();
            }

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
        // return response()->json(['message' => $we]);
    }

   
}
