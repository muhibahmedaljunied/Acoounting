<?php

namespace App\Http\Controllers\Absence;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Services\Core\HrService;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Models\AbsenceType;
use App\Models\Part;
use DB;


class AbsenceSanctionController extends Controller
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



        return response()->json([
            'list' => $this->get_absence_sanction(),
            'absence_types' => AbsenceType::all(),
            'absence_parts' => Part::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all()
        ]);
    }

    public function get_absence_sanction()
    {

        $absence_sanctions = Cache::rememberForever('absence_sanctions_index', function () {

            return DB::table('absence_sanctions')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->select(
                    'absence_sanctions.*',
                    'absence_types.name as absence',
                    'sanction_discounts.name as discount_name'
                )
                ->paginate(10);
        });

        return $absence_sanctions;
    }


    public function get_staff_absence_sanction(Request $request)
    {

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


            if ($value->sanctionable_type == 'App\\Models\\AbsenceSanction') {

                $absence = DB::table('absence_sanctions')->where('absence_sanctions.id', $value->sanctionable_id)
                    ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                    ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                    ->join('parts', 'parts.id', '=', 'absence_sanctions.part_id')
                    ->select(
                        'absence_sanctions.*',
                        'absence_types.name as type_name',
                        'parts.name as parts_name',
                        'sanction_discounts.name as discount_name'
                    )
                    ->get();

                $value->AbsenceSanction = $absence;
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

        Cache::forget('absence_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }


}
