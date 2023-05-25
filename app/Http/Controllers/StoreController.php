<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Exports\StoreExport;
use App\Imports\StoreImport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class StoreController extends Controller
{

    public function index()
    {


        $stores = DB::table('stores')
            ->select('stores.*')
            ->paginate(100);
        return response()->json($stores);
    }

    public function search(Request $request)
    {
        $stores = Store::where('stores.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->select('stores.*')
            ->paginate(10);
        return response()->json($stores);
    }

    public function tree_store()
    {

        $stores =  Cache::rememberForever('tree_store_stores',function(){

            return Store::where('parent_id', null)->with('children')->get();

        });
        $last_nodes = Cache::rememberForever('tree_store_last_nodes',function(){

            return Store::where('parent_id', null)->select('stores.*')->max('id');

        });
        return response()->json(['trees' => $stores, 'last_nodes' => $last_nodes]);
    }

   
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        // -------------------------------------------------------

        $Store = new Store();
        $Store->text = $request->post('text');
        if($request->post('parent') != 0){
            $Store->parent_id= $request->post('parent');
        }
        $Store->id = $request->post('store_id');
        $Store->rank = $request->post('rank');
        $Store->type_branch = $request->post('status');
        $Store->save();

        // Cache::forget(['tree_store_stores','tree_store_last_nodes']);

        return response()->json($request);
    }
    public function Store_details_node($id)
    {


        $details = DB::table('Stores')
            ->where('Stores.id', '=', $id)
            ->select('Stores.*')
            ->get();


        $childs = Store::where('parent_id', $id)->select('Stores.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }
    public function Store_update_node(Request $request,$id)
    {

        $data = Store::find($id);
        $data->text = $request->post('text');
        $data->save();

        return response()->json($data);


        // $store = Store::find($id);
        // $store->update($request->post());
        // return response()->json($store);


    }
    public function store_rename_node(Request $request,$id)
    {

        $store = Store::find($id);
        $store->text =$request->post('text');
        $store->save();

        return response()->json();
    }

    public function store_edit_node(Request $request,$id)
    {

    
        $data = Store::find($id);
        return response()->json(['data' => $data]);
    }





    public function create()
    {
        //
    }



    // public function Export( )      
    // {      
    //     $filename = '-store.xlsx';
    //     Excel::store(new StoreExport, $filename);
    //     $fullPath = Storage::disk('local')->path($filename);

    //     return response()->json([
    //         'data' => $fullPath,
    //         'message' => 'stores are successfully exported.'
    //     ], 200);

    // }

    // public function Import(Request $request)
    // {

    //     $filename = '-store.xlsx';
    //     return response()->json(Excel::import(new StoreImport, Storage::disk('local')->path($filename)));
    // }



    public function show($id)
    {
    }


    public function update(Request $request)
    {
        $store = Store::find($request->id);
        $store->update($request->post());
        return response()->json($request->post());
    }


    public function destroy($id)
    {
        $store = Store::find($id);

        $store->delete();

        return response()->json('successfully deleted');
    }
}
