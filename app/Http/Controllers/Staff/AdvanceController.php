<?php

namespace App\Http\Controllers\Staff;

use App\Models\Advance;
use App\Models\Staff;
use App\Services\Core\HrService;
use App\Services\AdvanceServic;
use App\Services\CoreStaffService;
use App\RepositoryInterface\PayrollRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\PayrollService;
use DB;

class AdvanceController extends Controller
{

    public function __construct(
        protected HRRepositoryInterface $hrRepo,
        protected HrService $hr,
        protected PayrollRepositoryInterface $payroll,
        protected CoreStaffService $core,
        // protected AdvanceServic $advance,
    ) {
    }
    public function index()
    {


        $advances = Staff::with(['advance'])->paginate(10);

        // ---------------------------------
        $this->hrRepo->Sum($advances, 'advance');

        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // -------------------------------------------------------------------------------------------------

        return response()->json(['staffs' => $staffs, 'list' => $advances]);
    }


    public function report(Request $request)
    {
        // 40036484981

        $advances = Staff::with(['advance' => function ($query) use ($request) {
            $query->select('advances.*')
            ->where('advances.staff_id','=', $request->staff)
            ->whereBetween('advances.date', array($request->post('from_date'), $request->post('into_date')));

        }])
        // 
        // ->whereBetween('date', array($request->post('from_date'), $request->post('into_date')))
        ->select('*')
        ->paginate(10);
        // dd($advances);
        $this->hrRepo->Sum($advances, 'advance');

        // dd($advances);
        return response()->json(['list' => $advances]);
    }
    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['advance'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }



    public function store(Request $request)
    {

        $this->core->setData($request->all());

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->store();
                // $this->payroll->refresh();
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            Cache::forget('staff_allowance');
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
