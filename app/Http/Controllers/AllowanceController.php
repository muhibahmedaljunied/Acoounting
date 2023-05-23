<?php

namespace App\Http\Controllers;

// use App\Traits\Staff\StoreTrait;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\Staff;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{

    // use StoreTrait;
    public function index()
    {

        // $staffs = Staff::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------



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



        $allowance_types = AllowanceType::all();
        return response()->json(['allowance_types' => $allowance_types, 'staffs' => $staffs, 'list' => $staff_allowances]);
    }


    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;
            if ($request->post('type') == 'allowance') {

                $temporale_f = tap(Allowance::whereAllowance($request))
                    ->update(['qty' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }

            if ($temporale_f->isEmpty()) {

                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
            // }
        }




        return response()->json(['message' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }








    public function show(Allowance $allowance)
    {
        //
    }


    public function edit(Allowance $allowance)
    {
        //
    }


    public function update(Request $request, Allowance $allowance)
    {
        //
    }


    public function destroy(Allowance $allowance)
    {
        //
    }
}
