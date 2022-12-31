<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     
    public function index()
    {
        

        $customers = DB::table('customers')
        ->select('customers.*')
        ->paginate(10);
        return response()->json($customers);
    }

    public function search(Request $request)      
    {      
        $customers = Customer::where('customers.name', 'LIKE', '%'.$request->post('word_search').'%')
        ->select('customers.*')
        ->paginate(10);
        return response()->json($customers);

        

    }

   
    public function create()
    {
    
    }


    // public function Export( )      
    // {      
    //     $filename = '-customers.xlsx';
    //     Excel::store(new CustomerExport, $filename);
    //     $fullPath = Storage::disk('local')->path($filename);

    //     return response()->json([
    //         'data' => $fullPath,
    //         'message' => 'supplier are successfully exported.'
    //     ], 200);

    // }


    // public function Import(Request $request)
    // {

    //     $filename = '-customers.xlsx';
    //     return response()->json(Excel::import(new CustomerImport,Storage::disk('local')->path($filename)));
       
    // }

    
    public function store(Request $request){
    	$customer = new Customer();
        $customer->name = $request->post('name');
        $customer->phone = $request->post('phone');
        $customer->email =$request->post('email');
        // $customer->password = bcrypt($request->post('password'));
        $customer->address = $request->post('address');
        // $customer->role_id = $request->post('role_id');
        $customer->status = $request->post('status');
        $customer->save();

        return back();
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json(['customer'=>$customer]);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update($request->post());
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json('successfully deleted');
    }
}
