<?php

namespace App\Http\Controllers;

use App\Traits\TemporaleTrait;
use App\Traits\StoreTrait;
use App\Traits\ReturnTrait;
use App\Traits\StockTrait;
use App\Traits\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\ReturnPurchaseDetail;
use App\Models\ReturnPurchase;

use Illuminate\Support\Facades\Auth;
use DB;

class PurchaseReturnController extends Controller
{
   

    use TemporaleTrait, StockTrait, StoreTrait, StoreProductTrait,ReturnTrait;

    public function index()
    {
    }

    // public function create(Request $request)
    // {

    //     $data = $request->post('return_purchase');
    //     $return = $request->post('return_qty');




    //     // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

    //     foreach ($data as  $value) {

    //         if ($value['qty_remain'] > $value['avilable_qty']) {


    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"]);
    //         } elseif ($value['qty_remain'] > $value['qty']) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  كميه الشراء"]);
    //         } elseif ($value['qty_remain'] == 0) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
    //         }
    //     }

    //     // return response()->json($request->post('return_purchase'));
    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //     $purchase_return = new ReturnPurchase();
    //     $purchase_return->purchase_id = $request->post('purchase_id');
    //     $purchase_return->date  = $request->post('date');
    //     $purchase_return->quantity = $request->post('total');
    //     $purchase_return->note  = $request->post('note');
    //     $purchase_return->save();


    //     DB::table('purchases')
    //         ->where('id', $request->post('purchase_id'))
    //         ->increment('qty_return', $request->post('total'));

    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //     foreach ($return as $key_qty => $value_qty) {




    //         if ($value_qty != null) {


    //             foreach ($data as  $value) {

    //                 if ($value_qty['product_id'] == $value['product_id'] && $value_qty['store_id'] == $value['store_id'] && $value_qty['status_id'] == $value['status_id'] && $value_qty['desc'] == $value['desc']) {

    //                     // -------------------------------------------------------------------------------------------------
    //                     $stock_f = 0;
    //                     $store_product_f = 0;
    //                     $store_product_f = $this->refresh_store($value,'return_purchase','decrement');

    //                     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //                     $id_store_product = $this->get($value);


    //                     foreach ($id_store_product as $values) {


    //                         $id_store_product = $values['id'];
    //                     }

    //                     if ($store_product_f == 0) {

    //                         $id_store_product = $this->init_store($value,'return_purchase');
    //                     }

    //                     //----------------------------------------------------------------------------------------------------------------------------------------- 


    //                     $this->init_details($purchase_return->id,$id_store_product,$value,'return_purchase',$request->all());

    //                     // -------------------------------------------------------------------------------------------------

    //                     $stock_f = $this->refresh_stock($purchase_return->id, $value, 'return_purchase', 'decrement');

    //                     PurchaseDetail::wherepurchase($value)->increment('qty_return', $value_qty['qty']);

    //                     // -------------------------------------------------------------------------------------------------


    //                     if ($stock_f == 0) {

    //                         $this->init_stock($purchase_return->id, $value, 'return_purchase', $request->post('date'));
    //                     }

    //                     // -------------------------------------------------------------------------------------------------
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json($request->post('total'));
    // }



    public function store(Request $request)
    {
        //
    }

    public function return_purchase_detail($id)
    {


        $return_details = DB::table('purchases')->where('return_purchase_details.purchase_return_id', $id)

            ->join('return_purchases', 'return_purchases.purchase_id', '=', 'purchases.id')
            ->join('return_purchase_details', 'return_purchases.id', '=', 'return_purchase_details.purchase_return_id')
            // ->join('store_products', 'store_products.id', '=', 'return_purchase_details.store_product_id')
            ->join('products', 'return_purchase_details.product_id', '=', 'products.id')
            ->join('statuses', 'return_purchase_details.status_id', '=', 'statuses.id')
            ->join('stores', 'return_purchase_details.store_id', '=', 'stores.id')
            ->select('return_purchase_details.*', 'return_purchase_details.quantity as qty_return', 'return_purchases.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'products.name as product_name')
            ->get();

        return response()->json(['return_details' => $return_details]);
    }


    public function return_invoice($id)
    {

        $return_purchases = ReturnPurchase::where('return_purchases.id', $id)
            ->join('purchases', 'purchases.id', '=', 'return_purchases.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.*', 'return_purchases.*', 'return_purchases.id as return_id')
            ->get();



        $return_details = ReturnPurchaseDetail::where('return_purchase_details.purchase_return_id', $id)
            ->join('return_purchases', 'return_purchases.id', '=', 'return_purchase_details.purchase_return_id')
            ->join('store_products', 'store_products.id', '=', 'return_purchase_details.store_product_id')
            ->joinall()
            ->select('return_purchase_details.*', 'return_purchase_details.quantity as qty_return', 'return_purchases.*', 'statuses.*', 'shelves.*', 'statuses.name as status', 'stores.*', 'products.name as product_name')
            ->get();

        $users = Auth::user();

        return response()->json(['return_details' => $return_details, 'return_purchases' => $return_purchases, 'users' => $users]);
    }

    public function show($id)
    {


        $return_purchases = DB::table('return_purchases')->where('return_purchases.purchase_id', $id)
            ->join('purchases', 'purchases.id', '=', 'return_purchases.purchase_id')
            ->select('return_purchases.*', 'return_purchases.date as return_date', 'return_purchases.quantity as qty_return', 'return_purchases.id as return_id', 'purchases.*')
            ->get();



        return response()->json(['return_purchases' => $return_purchases]);
    }
}
