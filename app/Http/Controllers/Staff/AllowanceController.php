<?php

namespace App\Http\Controllers\Staff;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Services\Core\HrService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\AllowanceType;
use App\Models\Staff;
use DB;
class AllowanceController extends Controller
{

    public function __construct(
        protected HrService $hr,
        protected PayrollRepositoryInterface $payroll,
        protected CoreStaffService $core,

    ) {
    }

    public function index()
    {


      
        return response()->json([
            'allowance_types' => AllowanceType::all(),
            'staffs' => $this->get_staff(),
            'list' =>$this->get_staff_allowance()
        ]);
    }


    public function get_staff (){

        
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return $staffs;

    }
    public function get_staff_allowance()
    {


        $staff_allowances = Cache::rememberForever('staff_allowances', function () {
            return staff::with([

                'allowance' => function ($query) {
                    $query->select('*');
                },

                'allowance.allowance_type' => function ($query) {
                    $query->select('*');
                },

            ])
                ->paginate(10);
        });

        return $staff_allowances;
    }
    public function store(Request $request)
    {
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->store();

                Cache::forget('staff_allowances');

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
