<?php

namespace App\Http\Controllers\Account;


use App\Models\Bank;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BankController extends Controller
{
    
   
    public function index()
    {

       

        $banks = Bank::all();
        return response()->json(['banks' => $banks]);
    }

    public function store(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'Bank_type' => 'required',
        //     'qty' => 'required',
            
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        foreach ($request->post('count') as $value) {
     
            $Bank = new Bank();
            $Bank->date =  $request->post('date');
            $Bank->Bank_type_id =  $request->all()['Bank_type'][$value];
            $Bank->quantity =  $request->all()['qty'][$value];

            $Bank->save();
            
           

        }
     
        return response()->json(['message' => 'success']);
    }

    
    public function create()
    {
        //
    }

    

    public function show()
    {
         $banks = DB::table('banks')
         ->join('accounts', 'accounts.id', '=', 'banks.account_id')
        ->select('banks.*','accounts.text','accounts.id as account_id')
     
        ->paginate(10);

        return response()->json(['banks' => $banks]);
    }

    
    public function edit()
    {
        //
    }

    
    public function update()
    {
        //
    }

   
    public function destroy()
    {
        //
    }
}
