<?php

namespace App\Http\Controllers\Staff;
use App\RepositoryInterface\HRRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Services\Core\HrService;
use App\Models\VacationType;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\StaffType;
use DB;

class VacationController extends Controller
{


    public function __construct(
        protected HRRepositoryInterface $hrRepo,        
        protected CoreStaffService $core,
        protected HrService $hr,
    ) {
    }

    public function index()
    {

        $vacations = staff::with(['vacation', 'vacation.vacation_type'])->paginate(10);
        $this->hrRepo->Sum($vacations, 'vaction');

        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------


        $vacation_types = VacationType::all();
        return response()->json([
            'list' => $vacations,
            'branches' => Branch::all(),
            'staff_types' => StaffType::all(),
            'staffs' => $staffs,
            'vacation_types' => $vacation_types
        ]);
    }

    public function report(Request $request){

        
        $vacations = Staff::with(['vacation' => function ($query) use ($request) {
            $query->select('vacations.*')
            ->where('vacations.staff_id','=', $request->staff)
            ->whereBetween('vacations.date', array($request->post('from_date'), $request->post('into_date')));

        }])
        ->select('*')
        ->paginate(10);
        // dd($advances);
        $this->hrRepo->Sum($vacations);

        // dd($advances);
        return response()->json(['list' => $vacations]);


    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['vacation', 'vacation.vacation_type'])->paginate(10);
        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request)
    {


        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {
                $this->core->setValue($value);
                $this->hr->store();
                // $this->payroll->refresh($request->all(), $value);

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

        return response()->json(['message' => $request->all()]);
    }

    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');



        return response()->json('successfully deleted');
    }

   
}
