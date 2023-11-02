<?php

namespace App\Http\Controllers\Leave;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Core\HrService;
use App\Models\SanctionDiscount;
use App\Services\CoreStaffService;
use App\Models\Part;
use App\Models\LeaveType;


use Illuminate\Http\Request;
use DB;

class LeaveSanctionController extends Controller
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
            'list' => $this->get_leave_sanction(),
            'leave_types' => LeaveType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all(),
            'leave_parts' => Part::all()
        ]);
    }

    
    public function get_leave_sanction(){


        $leave_sanctions = Cache::rememberForever('leave_sanctions_index', function () {

            return DB::table('leave_sanctions')
                ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                // ->join('leave_parts', 'leave_parts.id', '=', 'leave_sanctions.leave_part_id')
                ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
                ->select('leave_sanctions.*', 'leave_types.name as leave', 'parts.name as duration', 'sanction_discounts.name as discount_name')
                ->paginate(10);
        });

        return $leave_sanctions;

    }


    public function get_staff_leave_sanction(Request $request){


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

      
            if ($value->sanctionable_type == 'App\\Models\\LeaveSanction') {

                $leave = DB::table('leave_sanctions')->where('leave_sanctions.id', $value->sanctionable_id)
                    ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
                    ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                    ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
                    ->select(
                        'leave_sanctions.*', 
                    'leave_types.name as type_name',
                    'parts.name as parts_name',
                    'sanction_discounts.name as discount_name'
                    )
                    ->get();


                $value->LeaveSanction = $leave;
            }
         
        }

        return response()->json(['list' => $staff]);

    }



    public function store(Request $request)
    {
        $this->core->data = $request->all();
        foreach ($request->post('count') as $value) {

            $this->core->setValue($value);
            $this->hr->store();

        }
        Cache::forget('leave_sanctions_index');

        return response()->json(['message' => $request->all()]);
    }


}
