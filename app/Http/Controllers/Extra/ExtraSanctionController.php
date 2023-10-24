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
