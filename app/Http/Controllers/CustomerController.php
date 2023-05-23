<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;

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

    public function show(Request $request)
    {
        // return response()->json(['sales' => $request->all()]);

        $sales =  Sale::where('customer_id', $request->id)->with([
            'payment_sales' => function ($query) {
                $query->select('*');
            },
            'sale_returns' => function ($query) {
                $query->select('*');
            }
            // ,
            // 'receivable_notes' => function ($query) {
            //     $query->select('*');
            // }
          
        ])->paginate(10);


             

        
        return response()->json(['sales' => $sales]);
    }

    
    
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
