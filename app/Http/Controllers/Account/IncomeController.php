<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\income;
use App\Models\incomeType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class incomeController extends Controller
{
    
   
    public function index()
    {

        // $incomes = staff::with(['income','income.income_type'])->paginate(10);


        // 
        // $incomes = Staff::with('incomes')
        //     ->paginate(10);

        // $incomes = DB::table('incomes')
        // ->join('income_types','income_types.id', '=', 'incomes.income_type_id')
        // ->join('staff','staff.id', '=', 'incomes.staff_id')
        // ->select('incomes.*','income_types.name as income','staff.*')
        // ->paginate(10);

        $income_types = incomeType::all();
        // $staffs = Staff::all();
        return response()->json(['income_types' => $income_types]);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'income_type' => 'required',
            'qty' => 'required',
            
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        foreach ($request->post('count') as $value) {
     
            $income = new income();
            $income->date =  $request->post('date');
            $income->income_type_id =  $request->all()['income_type'][$value];
            $income->quantity =  $request->all()['qty'][$value];

            $income->save();
            
           

        }
     
        return response()->json(['message' => 'success']);
    }

    
    public function create()
    {
        //
    }

    

    public function show(income $income)
    {
         $incomes = DB::table('incomes')
        ->join('income_types','income_types.id', '=', 'incomes.income_type_id')
       
        ->select('incomes.*','income_types.name as income')
        ->paginate(10);

        return response()->json(['incomes' => $incomes]);
    }

    
    public function edit(income $income)
    {
        //
    }

    
    public function update(Request $request, income $income)
    {
        //
    }

   
    public function destroy(income $income)
    {
        //
    }
}
