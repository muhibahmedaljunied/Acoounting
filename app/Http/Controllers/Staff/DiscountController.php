<?php

namespace App\Http\Controllers\Staff;

use App\Services\Core\HrService;
use App\Http\Controllers\Controller;
use App\Services\DiscountService;
use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\CoreStaffService;
use App\Services\PayrollService;
use App\Models\Discount;
use App\Models\Staff;
use App\Models\DiscountType;
use App\Services\Core\HrService as CoreHrService;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DiscountController extends Controller
{


    public function __construct(
        protected HRRepositoryInterface $hrRepo,
        protected HrService $hr,
        protected PayrollRepositoryInterface $payroll,
        // protected DiscountService $discount,
        protected CoreStaffService $core,
    ) {
    }


    public function index()
    {

        $discounts = staff::with(['discount', 'discount.discount_type'])->paginate(10);

        $this->hrRepo->Sum($discounts, 'discount');
        $discount_types = DiscountType::all();
        // ------------------------------------------------------------------------------------------------
        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // -------------------------------------------------------------------------------------------------

        return response()->json(['discount_types' => $discount_types, 'staffs' => $staffs, 'list' => $discounts]);
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['discount', 'discount.discount_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request)
    {

        $this->core->data = $request->all();
        // dd($this->core->data);
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
