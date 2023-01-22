<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Exports\SupplierExport;
use App\Imports\SupplierImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }


    public function Export( )      
    {      
        $filename = '-suppliers.xlsx';
        Excel::store(new SupplierExport, $filename);
        $fullPath = Storage::disk('local')->path($filename);

        return response()->json([
            'data' => $fullPath,
            'message' => 'supplier are successfully exported.'
        ], 200);

    }


    public function Import(Request $request)
    {

        $filename = '-suppliers.xlsx';
        return response()->json(Excel::import(new SupplierImport,Storage::disk('local')->path($filename)));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
    	$user = new Supplier();
        $user->name = $request->post('name');
        $user->last_name = $request->post('last_name');
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
