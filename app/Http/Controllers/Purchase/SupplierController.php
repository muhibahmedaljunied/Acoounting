<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Services\SupplierService;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Storage;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $suppliers =  DB::table('suppliers')
            ->join('groups', 'groups.id', '=', 'suppliers.group_id')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'supplier')
            ->select(
                'suppliers.*',
                'groups.name as group_name'
            )
            ->paginate(10);




        return response()->json(['suppliers'=>$suppliers]);
    }

    public function search(Request $request)
    {

        $suppliers = Supplier::where('suppliers.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->select('suppliers.*')
            ->paginate(10);
        return response()->json($suppliers);
    }



    public function get_supplier_account_setting()
    {



        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'supplier')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();
        $group_accounts =  DB::table('groups')
            ->join('accounts', 'accounts.id', '=', 'groups.account_id')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'supplier')
            ->select(
                'groups.id as group_id',
                'groups.name as group_name',
                'accounts.id as account_id',
                'accounts.text as account_name'
            )
            ->get();
        return response()->json(['groups' => $groups, 'group_accounts' => $group_accounts]);
    }

    public function store_supplier_account_setting(Request $request)
    {


        $group_accounts = Group::find($request['group_id']);
        $group_accounts->update(['account_id' => $request['account_id']]);


        return response()->json(['message' => 'sucess']);
    }



    public function store(Request $request, SupplierService $supplier_service)
    {

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:2',
        //     'email' => 'required|email|unique:users',
        //     'phone'=>'required'
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            // // -------------------------------------------------------------------------
            // $supplier_service->get_parent();
            // // ---------------------------------------------------------------------------
            // $supplier_service->get_child();
            // // -------------------------------------------------------------------------
            // $supplier_service->add_account();
            // // -------------------------------------------------------------------------
            $supplier_service->add_supplier();




            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        return back();
    }





    public function show(Request $request)
    {


        $purchases =  Purchase::where('supplier_id', $request->id)
            ->with([

                'payable_notes' => function ($query) {
                    $query->select('*');
                },

                'payments' => function ($query) {
                    $query->select('*');
                },
                'purchase_returns' => function ($query) {
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
        return response()->json(['supplier' => $supplier]);
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
