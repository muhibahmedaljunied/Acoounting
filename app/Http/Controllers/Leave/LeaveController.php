<?php

namespace App\Http\Controllers\Leave;

use App\Services\Staff\LeaveService;
use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\LeaveRepository;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
use App\Models\Part;
use App\Models\Staff;
use Illuminate\Http\Request;

class LeaveController extends Controller
{


    public function __construct(

        protected CoreStaffService $core,
        protected LeaveService $leave_sanction,
        protected LeaveRepository $hr,



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
            'leave_types' => LeaveType::all(),
            'staffs' => $staffs
        ]);
    }


    public function get_staff_leave()
    {

        //  $minutes = 60;
        $staffs =  DB::table('leaves')
            ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->join('parts', 'parts.id', '=', 'leaves.part_id')
            ->join('staff', 'staff.id', '=', 'leaves.staff_id')
            ->select(
                'staff.name as staff_name',
                'staff.id as staff_id',
                'leaves.id as leave_id',
                'leaves.date',
                'parts.name as part_name',
                'leave_types.name as leave_type_name',

            )
            ->paginate();
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'leave_types' => LeaveType::all(),
            'leave_parts' => Part::all(),
            'staffs' => Staff::all(),
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
                $this->init_data_store();
                $this->hr->store();
                $this->leave_sanction->create();
            }

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Leave Created Successfully",
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

    public function init_data_store()
    {


        $this->hr->staff_id = $this->core->data['staff'][$this->core->value];
        $this->hr->leave_type_id = $this->core->data['leave_type'][$this->core->value];
        $this->hr->part_id = $this->core->data['leave_part'][$this->core->value];
        $this->hr->date = $this->core->data['date'][$this->core->value];
    }
}
