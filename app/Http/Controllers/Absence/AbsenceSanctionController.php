<?php

namespace App\Http\Controllers\Absence;
use App\Repository\StaffSaction\StaffAbsenceSanctionRepository;
use App\Repository\HR\AbsenceSanctionRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\AbsenceSanction;
use App\Services\CoreStaffService;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Models\AbsenceType;
use App\Models\StaffSanction;


class AbsenceSanctionController extends Controller
{

    public function __construct(
        protected AbsenceSanctionRepository $hr,
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

        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                AbsenceSanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id');
                    $query->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id');
                    $query->select(
                        'absence_sanctions.*',
                        'absence_types.name as type_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->where('sanctionable_type', 'App\\Models\\AbsenceSanction')
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


        // dd($request->all());
        $this->core->data = $request->all();

        foreach ($request->post('count') as $value) {

            $this->core->value = $value;

            $this->hr->handle();

            // }
        }

        Cache::forget('absence_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }


    public function change_status(
        Request $request,
        StaffAbsenceSanctionRepository $staff_sanction,
        PayrollService $payroll)
    {


        $this->core->data = $request->all();
        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();
        
            $payroll->payroll();

            // $daily->daily()->debit()->credit();  //this for create daily

            // if ($request->status == 1) {

            //     tap(Payroll::where('staff_id', $request->staff))
            //         ->increment('total_absence_sanction', $request->sanction)
            //         ->get();


            // }

            

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Absence Created Successfully",
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