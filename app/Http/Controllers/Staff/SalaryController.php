<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\StaffType;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use DB;
class SalaryController extends Controller
{

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

        $salaries = Cache::rememberForever('salaries_details', function () use ($request) {
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
                'advance' => function ($query) {
                    $query->select('*');
                },
                // 'extra.extra_type' => function ($query) {
                //     $query->select('*');
                // },
                'staff_sanction.sanctionable' => function ($query) {
                    $query->select('*');
                },
                // 'staff_sanction' => function ($query) {
                //     $query->where('sanctionable_type','!=','App\Models\ExtraSanction')->select('*');
                // },
                'extra.extra_detail.extra_sanction' => function ($query) {
                    $query->select('*');
                },
                'allowance.allowance_type' => function ($query) {
                    $query->select('*');
                },
                'discount.discount_type' => function ($query) {
                    $query->select('*');
                },

            ])
                ->paginate(10);
        });


        $this->sum($salaries);


        return response()->json(['list' => $salaries, 'staffs' => Staff::all()]);
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

        foreach ($salaries as $value) {

            $value->total = $value->salary+
            $value->total_allowance+
            $value->total_discount-
            $value->total_advance-
            $value->total_absence_sanction-
            $value->total_delay_sanction-
            $value->total_leave_sanction+
            $value->total_extra_sanction;

            $value->discount = $value->total_discount+$value->total_advance+
            $value->total_absence_sanction+
            $value->total_delay_sanction+
            $value->total_leave_sanction;
            $value->extra = $value->total_allowance+$value->total_extra_sanction;

            // $value->total_advance = $value->total_advance;
            // $value->all_allowance = $value->total_allowance;
            // $value->total = ($value->salary + $value->total_allowance + $value->total_extra) - ($value->all_discount);
 
        }




// dd($salaries);
        return response()->json(['list' => $salaries]);
    }
}
