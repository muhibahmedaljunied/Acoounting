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
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    public function index()
    {
        $branches = Branch::all();
        $jobs = Job::all();
        $staff_types = StaffType::all();
        $allowances = Allowance::all();
        $staffs = Staff::all();
        // $allowance_types = AllowanceType::all();

        $staff_allowances = DB::table('payrolls')
            ->join('staff', 'staff.id', '=', 'payrolls.staff_id')
            ->select('staff.name as staff', 'payrolls.*')
            ->paginate(10);



        return response()->json(['staff_allowances' => $staff_allowances,'allowance_types' => $allowance_types, 'staffs' => $staffs, 'jobs' => $jobs, 'branches' => $branches, 'staff_types' => $staff_types, 'allowances' => $allowances]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        return response()->json($request->all());

        



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

    public function salary_details()
    {

        // $salaries =  staff::with([
        //     'extra' => function ($query) {
        //         $query->join('extra_types', 'extras.extra_type_id', '=', 'extra_types.id')->select('*',DB::raw('sum(number_hours) as muh1'))->groupBy('extras.*');
        //     },
        //     'allowance' => function ($query) {
        //         $query->join('allowance_types', 'allowances.allowance_type_id', '=', 'allowance_types.id')->select('*',DB::raw('sum(qty) as muh2')->groupBy('allowances.*'));
        //     },
        //     'discount' => function ($query) {
        //         $query->join('discount_types', 'discounts.discount_type_id', '=', 'discount_types.id')->select('*',DB::raw('sum(quantity) as muh3')->groupBy('discounts.*'));
        //     }
        // ])
        // ->paginate(10);



        $salaries =  staff::with([
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



            $staffs = Staff::all();

        return response()->json(['salaries' => $salaries,'staffs'=>$staffs]);
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
