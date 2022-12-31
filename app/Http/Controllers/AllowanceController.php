<?php

namespace App\Http\Controllers;

// use App\Traits\Staff\StoreTrait;
use App\Models\Allowance;
use App\Models\AllowanceType;
use App\Models\Staff;
use DB;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{

    // use StoreTrait;
    public function index()
    {
        // $absences = DB::table('absences')
        // ->join('absence_types','absence_types.id', '=', 'absences.absence_type_id')
        // ->join('staff','staff.id', '=', 'absences.staff_id')

        // ->select('absences.*','absence_types.name as absence','staff.name as staff')
        // ->paginate(10);

        $allowance_types = AllowanceType::all();
        // $staffs = Staff::all();
        return response()->json(['allowance_types' => $allowance_types]);
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

    public function store(Request $request)
    {


        return response()->json(['message' => $request->all()]);

        for ($i=1; $i < 3 ; $i++) { 
            $type_allowance = $request->post('count');
            // return response()->json(['message' =>$type_allowance]);
            foreach ($type_allowance as $value) {
                return response()->json(['message' =>$request->allow['allow_1']]);

                $temporale_f = 0;


                $temporale_f = tap(Allowance::where(['staff_id' => $request['staff'][$value], 'allowance_type_id' => $request['allowance_type'][$value]]))
                    ->update(['qty' => $request['qty'][$value]])
                    ->get('id');
                $this->refresh_payroll($request->all(), $value, $request->post('type'));



                if (count($temporale_f) == 0) {



                    $this->add($request->all(), $value, $request->post('type'));
                    $this->refresh_payroll($request->all(), $value, $request->post('type'));
                }
                // }
            }

        }

        
        // foreach ($request->post('count') as $value) {

        
        //     $type_allowance = $value;

        //     return response()->json(['message' => $value]);
           
        // }




        return response()->json(['message' => $request->all()]);
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
