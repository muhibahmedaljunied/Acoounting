<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Branch;
use App\Models\Job;
use App\Models\StaffType;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\Staff;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    public function index()
    {
        $branches = Branch::all();
        $staff_types = StaffType::all();
        $allowances = Allowance::all();
        // $staffs = Staff::all();
        // ----------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        $re =Cache::get('staff');
        // ----------------------------------------------------------------------------
    
        $allowance_types = AllowanceType::all();

        $staff_allowances = DB::table('payrolls')
            ->join('staff', 'staff.id', '=', 'payrolls.staff_id')
            ->select('staff.name as staff', 'payrolls.*')
            ->paginate(10);



        return response()->json(['staff_allowances' => $staff_allowances, 'allowance_types' => $allowance_types, 'staffs' => $staffs, 'jobs' => $jobs, 'branches' => $branches, 'staff_types' => $staff_types, 'allowances' => $allowances]);
    }

    public function create()
    {
        //
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





        $staff_allowance = Allowance::where('allowances.staff_id', $request->post('staff_id'))
            ->select('allowances.*')
            ->get();

        if (count($staff_allowance) == 0) {
            foreach ($request->post('allowance')  as $value) {


                $staff_allowance = new Allowance();
                $staff_allowance->staff_id = $value['name'];
                $staff_allowance->allowance_id = $value['id'];
                $staff_allowance->date = $request->post('date');
                // $staff_allowance->salary = $request->post('salary');
                $staff_allowance->checked = $value['check'];
                $staff_allowance->qty = $value['qty'];
                $staff_allowance->save();

                // }



            }
            // return response()->json($request->all());
        }


        DB::table('staff')
            ->where('id', $request->post('staff_id'))
            ->update(array(
                'salary' => $request->post('salary'),
            ));


        foreach ($request->post('allowance')  as $value) {




            DB::table('allowances')
                ->where('staff_id', $value['name'])
                ->where('allowance_id', $value['id'])
                ->update(array(
                    'checked' => $value['check'],
                    'date' => $request->post('date'),
                    'qty' => $value['qty'],
                    // 'salary'=>$request->post('salary'),
                ));
        }







        return response()->json($request->all());
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
                'extra.extra_type' => function ($query) {
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





        // $salaries =  staff::where('id', $request->id)->with([
        //     'payroll' => function ($query) {
        //         $query->select('*');
        //     },
        //     'extra' => function ($query) {
        //         $query->select('*');
        //     },
        //     'allowance' => function ($query) {
        //         $query->select('*');
        //     },
        //     'discount' => function ($query) {
        //         $query->select('*');
        //     },
        //     'advance' => function ($query) {
        //         $query->select('*');
        //     },
        //     'extra.extra_type' => function ($query) {
        //         $query->select('*');
        //     },
        //     'allowance.allowance_type' => function ($query) {
        //         $query->select('*');
        //     },
        //     'discount.discount_type' => function ($query) {
        //         $query->select('*');
        //     },

        // ])
        //     ->paginate(10);



        $staffs = Staff::all();

        return response()->json(['list' => $salaries, 'staffs' => $staffs]);
    }

    public function salary()
    {



        $salaries = DB::table('staff')
            ->join('payrolls', 'payrolls.staff_id', '=', 'staff.id')
            ->select('payrolls.*', 'staff.*')
            ->paginate(100);

        foreach ($salaries as $value) {



            $value->total = ($value->salary + $value->total_allowance + $value->total_extra) - ($value->total_advance + $value->total_discount);
        }





        return response()->json(['list' => $salaries]);
    }


    public function show(Salary $salary)
    {
        //
    }


    public function edit(Salary $salary)
    {
        //
    }


    public function update(Request $request, Salary $salary)
    {
        //
    }


    public function destroy(Salary $salary)
    {
        //
    }
    // 119150
}
