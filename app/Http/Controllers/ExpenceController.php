<?php

namespace App\Http\Controllers;


use App\Models\Expence;
use App\Models\ExpenceType;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    
   
    public function index()
    {

        // $Expences = staff::with(['Expence','Expence.Expence_type'])->paginate(10);


        // 
        // $Expences = Staff::with('Expences')
        //     ->paginate(10);

        // $Expences = DB::table('Expences')
        // ->join('Expence_types','Expence_types.id', '=', 'Expences.Expence_type_id')
        // ->join('staff','staff.id', '=', 'Expences.staff_id')
        // ->select('Expences.*','Expence_types.name as Expence','staff.*')
        // ->paginate(10);

        $expence_types = ExpenceType::all();
        // $staffs = Staff::all();
        return response()->json(['expence_types' => $expence_types]);
    }

    public function store(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'expence_type' => 'required',
        //     'qty' => 'required',
            
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        foreach ($request->post('count') as $value) {
     
            $expence = new Expence();
            $expence->date =  $request->post('date');
            $expence->expence_type_id =  $request->all()['expence_type'][$value];
            $expence->quantity =  $request->all()['qty'][$value];

            $expence->save();
            
           

        }
     
        return response()->json(['message' => 'success']);
    }

    
    public function create()
    {
        //
    }

    

    public function show(Expence $Expence)
    {
         $expences = DB::table('expences')
        ->join('expence_types','expence_types.id', '=', 'expences.expence_type_id')
       
        ->select('expences.*','expence_types.name as expence')
        ->paginate(10);

        return response()->json(['expences' => $expences]);
    }

    
    public function edit(Expence $Expence)
    {
        //
    }

    
    public function update(Request $request, Expence $Expence)
    {
        //
    }

   
    public function destroy(Expence $Expence)
    {
        //
    }
}
