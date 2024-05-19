<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Account;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use App\Models\StoreAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\StoreImport;
use App\Exports\StoreExport;
use App\Services\FilterService;
use App\Models\Store;
use Illuminate\Support\Facades\DB;



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

        $stores =  Cache::rememberForever('tree_store_stores', function () {

            return Store::where('parent_id', null)->with('children')->get();
        });
        $last_nodes = Cache::rememberForever('tree_store_last_nodes', function () {

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

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $this->add_store($request);

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "store created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        Cache::forget('tree_store_stores');
        Cache::forget('tree_store_last_nodes');



        return response()->json($request);
    }

    public function get_store_account_setting()
    {



        $store_accounts =  DB::table('stores')
            ->join('accounts', 'accounts.id', '=', 'stores.account_id')
            ->select(
                'stores.id as store_id',
                'stores.text as store_name',
                'accounts.id as account_id',
                'accounts.text as account_name'
            )
            ->get();
        // dd($store_accounts);
        return response()->json(['store_accounts' => $store_accounts]);
    }

    public function store_store_account_setting(Request $request, FilterService $filter)
    {




        $filter->store_id =  $request->store_id;
        // dd($request->store_id,$request['account_id']);
        $this->update_store($request->store_id,$request['account_id']);
        $filter->queryfilter();

        foreach ($filter->data as $key => $value) {

         $this->update_store($value,$request['account_id']);
        }

        return response()->json(['message' => 'sucess']);

    }

    public function update_store($value,$account_id)
    {
        $stores = Store::find($value);
        $stores->update(['account_id' => $account_id]);
        // dd($stores);
    }
    public function add_store($request)
    {


        if ($request->post('account') == null) {


            $store = new Store();
            $store->id = $request->store_id;
            $store->text = $request['text'];
            if ($request['parent'] != 0) {
                $store->parent_id = $request['parent'];
            }
            $store->rank = $request['rank'];
            $store->status = $request['status'];
            $store->save();
        } else {

            $parent =  DB::table('accounts')
                ->where('accounts.id', $request->post('account'))
                ->select(
                    'accounts.*',

                )
                ->first();
            // ---------------------------------------------------------------------------

            $childs = Account::where('parent_id', $parent->id)->select('accounts.*')->max('id');
            $id = ($childs == null) ? $request->post('account') * 10 + 1 : $childs + 1;


            // --------------------------------------------------------------------------------
            $account = new Account();
            $account->id = $id;
            $account->text = $request['text'];
            $account->parent_id = $parent->id;
            $account->rank = $parent->rank + 1;
            $account->status_account = false;
            $account->save();

            // -------------------------------------------------------------------------

            $store = new Store();
            $store->text = $request['text'];
            $store->id = $request->store_id;
            // $store->account_id = $id;
            if ($request['parent'] != 0) {
                $store->parent_id = $request['parent'];
            }
            $store->rank = $request['rank'];
            $store->status = $request['status'];
            $store->save();
        }

        // dd($store->id);

        return $store->id;
    }

    public function import(Request $request)
    {

        Excel::import(new StoreImport, storage_path('store.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported to database in laravel 9'
        ]);
    }


    public function export()
    {

        return Excel::download(new StoreExport, 'store.xlsx');
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
    public function Store_update_node(Request $request, $id)
    {

        $data = Store::find($id);
        $data->text = $request->post('text');
        $data->save();

        return response()->json($data);
    }
    public function store_rename_node(Request $request, $id)
    {

        $store = Store::find($id);
        $store->text = $request->post('text');
        $store->save();

        return response()->json();
    }

    public function store_edit_node(Request $request, $id)
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
