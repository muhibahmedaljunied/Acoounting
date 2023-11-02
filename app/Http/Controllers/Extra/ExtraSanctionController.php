<?php

namespace App\Http\Controllers\Extra;

use App\Services\Core\HrService;
use App\Services\CoreStaffService;
use App\Models\ExtraType;
use App\Models\Part;
use App\Models\SanctionDiscount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use DB;

class ExtraSanctionController extends Controller
{

    public function __construct(
        protected CoreStaffService $core,
        protected HrService $hr,
    ) {
    }
    public function index()
    {


        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'list' => $this->get_extra_sanction(),
            'extra_types' => ExtraType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all(),
            'extra_parts' => Part::all()
        ]);
    }


    public function get_extra_sanction()
    {

        $extra_sanctions =  DB::table('extra_sanctions')
            ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('extra_sanctions.*', 'parts.name as duration', 'extra_types.name as extra', 'sanction_discounts.name as discount_name')
            ->paginate(10);

        return $extra_sanctions;
    }

    public function get_staff_extra_sanction(Request $request)
    {


        $staff_extra_sanction = DB::table('extras')
            ->join('staff', 'staff.id', '=', 'extras.staff_id')
            ->join('extra_types', 'extra_types.id', '=', 'extras.extra_type_id')
            ->join('extra_details', 'extra_details.extra_id', '=', 'extras.id')
            ->join('extra_sanctions', 'extra_sanctions.id', '=', 'extra_details.extra_sanction_id')
            ->select(
                'staff.id as staff_id',
                'staff.name as staff_name',
                'extras.id as extra_id',
                'extras.date',
                'extras.number_hours as number_hours',
                'extra_details.*', 
                'extra_sanctions.id as sanction_id', 
                'extra_sanctions.sanction',
                'extra_types.name as extra_type',
                'extra_types.id as extra_type_id'
                )
            ->get();


            // dd($staff_extra_sanction);
        return response()->json(['list' => $staff_extra_sanction]);
    }




    public function store(Request $request)
    {

        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->store();
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        Cache::forget('extra_sanctions_index');
        Cache::forget('staff');
        return response()->json(['message' => $request->all()]);
    }
}
