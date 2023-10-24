<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Store;
use App\Models\StoreAccount;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


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


        
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'text' => 'required',
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }
        
        // -------------------------------------------------------

        $this->add_store($request);
        $this->add_store_account($request);
   
        Cache::forget('tree_store_stores');
        Cache::forget('tree_store_last_nodes');



        return response()->json($request);
    }
    public function add_store($request){

        $Store = new Store();
        $Store->text = $request['text'];
        if($request['parent'] != 0){
            $Store->parent_id= $request['parent'];
        }
     
        $Store->rank = $request['rank'];
        $Store->status = $request['status'];
        $Store->save();



    }

    public function add_store_account($request){

        $Store_account = new StoreAccount();
        $Store_account->store_id = $request['store_id'];
        $Store_account->account_id = $request['account'];
        $Store_account->save();
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
