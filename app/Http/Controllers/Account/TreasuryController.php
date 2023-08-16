<?php

namespace App\Http\Controllers\Account;


use App\Models\Treasury;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    
   
    public function index()
    {

       

        $treasuries = Treasury::all();
        return response()->json(['treasuries' => $treasuries]);
    }

    public function store(Request $request)
    {


       

        foreach ($request->post('count') as $value) {
     
            $Bank = new Treasury();
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
         $treasuries = DB::table('treasuries')
         ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
        ->select('treasuries.*','accounts.text','accounts.id as account_id')
        ->paginate(10);

        return response()->json(['treasuries' => $treasuries]);
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
