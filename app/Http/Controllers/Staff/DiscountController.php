<?php

namespace App\Http\Controllers\Staff;

use App\Services\DailyService;
use App\Repository\HR\DiscountRepository;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Models\Staff;
use App\Models\DiscountType;
use App\Models\HrAccount;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DiscountController extends Controller
{


    public function __construct(
        protected DiscountRepository $hr,
        protected CoreStaffService $core,
    ) {
    }


    public function index()
    {

        $discounts = staff::with(['discount', 'discount.discount_type'])->paginate(10);

        $this->hr->Sum($discounts, 'discount');
        $discount_types = DiscountType::all();
        // ------------------------------------------------------------------------------------------------
        $minutes = 60;
        // $staffs = Cache::remember('staff', $minutes, function () {
        //     return DB::table('staff')->get();
        // });

        $staffs =  DB::table('staff')
            ->select(
                'staff.name',
                'staff.id',
            )
            ->get();

        // -------------------------------------------------------------------------------------------------

        return response()->json([
            'discount_types' => $discount_types,
            'staffs' => $staffs,
            'list' => $discounts,
            'debit'=>HrAccount::where('code','discount')->select('account_id','id as hr_account_id')->get(),

        ]);
    }

    public function report(Request $request)
    {


        $discounts = Staff::with(['discount' => function ($query) use ($request) {
            $query->select('discounts.*')
                ->where('discounts.staff_id', '=', $request->staff)
                ->whereBetween('discounts.date', array($request->post('from_date'), $request->post('into_date')));
        }])
            ->select('*')
            ->paginate(10);
        // dd($advances);
        $this->hr->Sum($discounts);

        // dd($advances);
        return response()->json(['list' => $discounts]);
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['discount', 'discount.discount_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request, DailyService $daily, PayrollService  $payroll)
    {
        // dd($request->all());
        $this->core->setData($request->all());
     
        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->handle();
                $payroll->refresh_payroll_for_hr();
                // $daily->daily()->debit()->credit();
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
