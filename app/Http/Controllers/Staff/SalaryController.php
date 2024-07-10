<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\StaffType;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\HrAccount;
use App\Models\Staff;
use App\Services\CoreStaffService;
use App\Services\Daily\DailySalaryService;
use App\Services\DailyService;
use App\Services\PayrollService;
use App\Services\SalaryService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{


    public $staff;

    public function __construct(
        protected CoreStaffService $core,
        public DailyService $daily,
        public DailySalaryService $daily_salary,
        public PayrollService $payroll,
        public SalaryService $salary,
    ) {

        $this->daily = $daily;
    }

    public function index()
    {
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        $staff_allowances = Cache::rememberForever('staff_allowances', function () {
            return DB::table('payrolls')
                ->join('staff', 'staff.id', '=', 'payrolls.staff_id')
                ->select('staff.name as staff', 'payrolls.*')
                ->paginate(10);
        });



        return response()->json([
            'staff_allowances' => $staff_allowances,
            'allowance_types' => AllowanceType::all(),
            'staffs' => $staffs,
            'branches' => Branch::all(),
            'staff_types' => StaffType::all(),
            'allowances' => Allowance::all()
        ]);
    }



    public function select_staff(Request $request)
    {

        $salaries = Cache::rememberForever('attenances', function () use ($request) {
            return staff::where('id', $request->id)->with([
                'payroll' => function ($query) {
                    $query->select('*');
                },
                'extra' => function ($query) {
                    $query->select('*');
                },
                'allowance' => function ($query) {
                    $query->select('*');
                },
                'discount' => function ($query) {
                    $query->select('*');
                },
                'extra.extra_type' => function ($query) {
                    $query->select('*');
                },
                'allowance.allowance_type' => function ($query) {
                    $query->select('*');
                },
                'discount.discount_type' => function ($query) {
                    $query->select('*');
                }
            ])
                ->paginate(10);
        });




        return response()->json(['list' => $salaries]);
    }


    public function store(Request $request)
    {

        // return response()->json($request->all());

        $staff_allowance = $this->get_staff_allowance($request);

        if (count($staff_allowance) == 0) {

            $this->init_allowance($request);
        }

        $this->update_staff($request);

        $this->update_allowance($request);

        return response()->json($request->all());
    }

    public function prove_salary(Request $request)
    {


        $this->core->setData($request->all());
        try {

            DB::beginTransaction();

            $this->daily->daily()->debit()->credit();
            $this->payroll->refresh_payroll_status($this->core->data['staff'], 'prove');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Salary proved successfully",
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
    public function prove_all_salary(Request $request)
    {


        $this->core->setData($request->all());


        try {

            DB::beginTransaction();

            $this->daily->daily();
            foreach ($this->core->data['data_staff'] as $key => $value) {
                $this->staff = $this->core->data['data_staff'][$this->core->value]['id'];
                $this->core->setValue($key);
                $this->daily->debit()->credit();
                $this->payroll->refresh_payroll_status($this->staff, 'prove');
            }


            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Salary proved successfully",
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

    public function paid_salary(Request $request)
    {


        $this->core->setData($request->all());
        $this->salary->staff = $this->core->data['staff'];

        try {

            DB::beginTransaction();
            $this->salary->handle();
            $this->daily_salary->daily()->debit()->credit();
            $this->payroll->refresh_payroll_status($this->salary->staff, 'paid');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Salary proved successfully",
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
    public function paid_all_salary(Request $request)
    {


        $this->core->setData($request->all());
        try {

            DB::beginTransaction();

            foreach ($this->core->data['data_staff'] as $key => $value) {


                $this->core->setValue($key);
                $this->salary->staff = $this->core->data['data_staff'][$this->core->value]['id'];
                $this->salary->handle();
                $this->daily_salary->daily()->debit()->credit();
                $this->payroll->refresh_payroll_status($this->salary->staff, 'paid');
            }


            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Salary proved successfully",
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



    public function get_staff_allowance($request)
    {

        $staff_allowance = Allowance::where('allowances.staff_id', $request['staff_id'])
            ->select('allowances.*')
            ->get();

        return $staff_allowance;
    }
    public function update_staff($request)
    {

        DB::table('staff')
            ->where('id', $request['staff_id'])
            ->update(array(
                'salary' => $request['salary'],
            ));
    }
    public function init_allowance($request)
    {


        foreach ($request['allowance']  as $value) {

            $staff_allowance = new Allowance();
            $staff_allowance->staff_id = $value['name'];
            $staff_allowance->allowance_id = $value['id'];
            $staff_allowance->date = $request['date'];
            // $staff_allowance->salary = $request->post('salary');
            $staff_allowance->checked = $value['check'];
            $staff_allowance->qty = $value['qty'];
            $staff_allowance->save();

            // }



        }
    }

    public function update_allowance($request)
    {


        foreach ($request['allowance']  as $value) {

            DB::table('allowances')
                ->where('staff_id', $value['name'])
                ->where('allowance_id', $value['id'])
                ->update(array(
                    'checked' => $value['check'],
                    'date' => $request['date'],
                    'qty' => $value['qty'],
                    // 'salary'=>$request->post('salary'),
                ));
        }
    }

    public function salary_details(Request $request)
    {


        $salaries = DB::table('staff')->where('staff.id', $request->id)
            ->join('payrolls', 'payrolls.staff_id', '=', 'staff.id')
            // ->join('allowances', 'allowances.staff_id', '=', 'staff.id')
            // ->join('allowance_types', 'allowance_types.id', '=', 'allowances.allowance_type_id')
            ->select(
                'payrolls.*',
                'staff.*'
                // 'allowance_types.name as type_name','allowances.quantity as quantity_allowance'
            )
            ->paginate(100);

        foreach ($salaries as $value) {

            $value->total = $value->salary +
                $value->total_allowance -
                $value->total_discount -
                $value->total_advance -
                $value->total_absence_sanction -
                $value->total_delay_sanction -
                $value->total_leave_sanction +
                $value->total_extra_sanction;

            $value->discount = $value->total_discount + $value->total_advance +
                $value->total_absence_sanction +
                $value->total_delay_sanction +
                $value->total_leave_sanction;
            $value->extra = $value->total_allowance + $value->total_extra_sanction;

            // $value->total_advance = $value->total_advance;
            // $value->all_allowance = $value->total_allowance;
            // $value->total = ($value->salary + $value->total_allowance + $value->total_extra) - ($value->all_discount);

        }




        // dd($salaries);
        return response()->json(['list' => $salaries]);
    }

    public function sum($salaries)
    {

        foreach ($salaries as $sub) {


            // dd($sub);
            $sub->sum_discount = 0;
            $sub->sum_allowance = 0;
            $sub->sum_extra = 0;
            $sub->sum_sanction = 0;

            // -------------------------------------------allowance-------------------------------------------------

            foreach ($sub->allowance as $key => $value_allowance) {

                $sub->sum_allowance += $value_allowance->qty;
            }
            // -------------------------------------------------discount-------------------------------------------
            foreach ($sub->discount as $key => $value_discount) {

                $sub->sum_discount += $value_discount->quantity;
            }
            // ---------------------------------------------sanction-----------------------------------------------

            foreach ($sub->staff_sanction as $key => $value_sanction) {

                if ($value_sanction->sanctionable->delay_type_id) {

                    $sub->sum_sanction += $value_sanction->sanctionable->sanction;
                }
                if ($value_sanction->sanctionable->leave_type_id) {

                    $sub->sum_sanction += $value_sanction->sanctionable->sanction;
                }

                if ($value_sanction->sanctionable->extra_type_id) {

                    $sub->sum_extra += $value_sanction->sanctionable->sanction;
                }
            }
            // --------------------------------------extra------------------------------------------------------

            foreach ($sub->extra as $key => $value_extra) {

                foreach ($value_extra->extra_detail as $details) {

                    $sub->sum_extra += $details->extra_sanction->sanction;
                }
            }
        }
    }
    public function salary()
    {



        $salaries = DB::table('staff')
            ->join('payrolls', 'payrolls.staff_id', '=', 'staff.id')
            ->select('payrolls.*', 'staff.*')
            ->paginate(100);
        $basic_salary = 0;
        $net_salary = 0;
        foreach ($salaries as $value) {

            $value->total = $value->salary +
                $value->total_allowance -
                $value->total_discount -
                $value->total_advance -
                $value->total_absence_sanction -
                $value->total_delay_sanction -
                $value->total_leave_sanction +
                $value->total_extra_sanction;

            $value->discount = $value->total_discount + $value->total_advance +
                $value->total_absence_sanction +
                $value->total_delay_sanction +
                $value->total_leave_sanction;
            $value->extra = $value->total_allowance + $value->total_extra_sanction;

            // $value->total_advance = $value->total_advance;
            // $value->all_allowance = $value->total_allowance;
            // $value->total = ($value->salary + $value->total_allowance + $value->total_extra) - ($value->all_discount);

            $net_salary = $net_salary + $value->total;
            $basic_salary = $basic_salary + $value->salary;
        }




        // dd($salaries);
        return response()->json([
            'list' => $salaries,
            'net_salary' => $net_salary,
            'basic_salary' => $basic_salary,
            'staff' => DB::table('staff')->select('staff.name', 'staff.id', 'staff.salary')->get(),
            'prove_account' => HrAccount::where('code', 'salary')
                ->select('account_id', 'id as hr_account_id', 'account_second_id')
                ->get(),
            'paid_account' => HrAccount::whereIn('type', ['salary', 'extra', 'allowance'])
                ->select('account_id', 'id as hr_account_id', 'account_second_id', 'type', 'code')
                ->get(),
        ]);
    }
}
