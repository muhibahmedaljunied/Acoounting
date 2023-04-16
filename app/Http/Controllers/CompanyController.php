<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Storage;
use DB;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $companies = DB::table('companies')
        ->select('companies.*')
        ->paginate(10);
        return response()->json($companies);
    }

    public function search(Request $request)      
    {      
        $suppliers = Company::where('companies.name', 'LIKE', '%'.$request->post('word_search').'%')
        ->select('companies.*')
        ->paginate(10);
        return response()->json($suppliers);

        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }


   



  
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:2',
            'email' => 'required|email|unique:users',
            'phone'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        


        // ---------------------------------------------------------------
    	$user = new Company();
        $user->name = $request->post('name');
        $user->email =$request->post('email');
        $user->phone =$request->post('phone');

        $user->address = $request->post('address');

        $user->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Company::find($id);
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
        $supplier = Company::find($request->id);
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
        $supplier = Company::find($id);

        $supplier->delete();

        return response()->json('successfully deleted');
    }
}
