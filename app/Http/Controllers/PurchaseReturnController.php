<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\GeneralTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturn;
use App\Facades\Returns;
use Illuminate\Support\Facades\Auth;
use DB;

class PurchaseReturnController extends Controller
{

    use TemporaleTrait,
        StockTrait,
        StoreProductTrait,
        GeneralTrait,
        ReturnDetailsTrait;

    public function index()
    {
    }


    public function return_invoice($id)
    {

        $purchase_returns = PurchaseReturn::where('purchase_returns.id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.*', 'purchase_returns.*', 'purchase_returns.id as return_id')
            ->get();



        $return_details = PurchaseReturnDetail::where('purchase_return_details.purchase_return_id', $id)
            ->join('purchase_returns', 'purchase_returns.id', '=', 'purchase_return_details.purchase_return_id')
            ->join('store_products', 'store_products.id', '=', 'purchase_return_details.store_product_id')
            ->joinall()
            ->select('purchase_return_details.*', 'purchase_return_details.qty as qty_return', 'purchase_returns.*', 'statuses.*', 'shelves.*', 'statuses.name as status', 'stores.*', 'products.text as product_name')
            ->get();

        $users = Auth::user();

        return response()->json(['return_details' => $return_details, 'purchase_returns' => $purchase_returns, 'users' => $users]);
    }

    public function show($id)
    {


        $returns = DB::table('purchase_returns')->where('purchase_returns.purchase_id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->select('purchase_returns.*', 'purchase_returns.date as return_date', 'purchase_returns.quantity as qty_return', 'purchase_returns.id as return_id', 'purchases.*')
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        $request_data = $request->post('old'); //this conten the prev data
        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            // -----------------------------------------------------------------------------------------------------------------
            foreach ($request_data as $value) {

                $qty_after_convert = Returns::check_return($value);

                if ($qty_after_convert['message'] == 0) {

                    return response()->json(['message' => 0, 'text' => $qty_after_convert['text']]);
                }
            }

            // -------------------------------------------------------------------------------------------------
            $return_id = Returns::store_return($request->all());
            // -------------------------------------------------------------------------------------------------

            foreach ($request_data as $value) {

                $data = array_merge($request->except('old'), $value);
                $data['qty'] = $qty_after_convert['qty'];

                $responce = Returns::create($data, $return_id);
            }

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => $responce,
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $responce,
                'status' => 'failed'
            ], 400);
        }

        // return response()->json(['message' => $responce]);
    }
}
