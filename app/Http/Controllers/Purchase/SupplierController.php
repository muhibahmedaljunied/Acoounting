<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use Storage;
use DB;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $suppliers = DB::table('suppliers')
        ->select('suppliers.*')
        ->paginate(10);
        return response()->json($suppliers);
    }

    public function search(Request $request)      
    {      
        $suppliers = Supplier::where('suppliers.name', 'LIKE', '%'.$request->post('word_search').'%')
        ->select('suppliers.*')
        ->paginate(10);
        return response()->json($suppliers);

        

    }

    


 

    public function store(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:2',
        //     'email' => 'required|email|unique:users',
        //     'phone'=>'required'
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }
        

        // dd($request->all());
        // ---------------------------------------------------------------
    	$user = new Supplier();
        $user->name = $request->post('name');
        $user->last_name = $request->post('last_name');
        $user->email =$request->post('email');
        $user->phone =$request->post('phone');
        $user->account_id =$request->post('account');
        $user->address = $request->post('address');
        $user->save();
        return back();
    }

   
    public function show(Request $request)
    {
        $purchases =  Purchase::where('supplier_id', $request->id)->with([
            'payment_purchases' => function ($query) {
                $query->select('*');
            },
            'purchase_returns' => function ($query) {
                $query->select('*');
            },
            'payable_notes' => function ($query) {
                $query->select('*');
            }
          
        ])
            ->paginate(10);


             

        
        return response()->json(['purchases' => $purchases]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return response()->json(['supplier'=>$supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->update($request->post());
        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        $supplier->delete();

        return response()->json('successfully deleted');
    }
}
