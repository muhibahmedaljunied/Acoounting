<?php

namespace App\Http\Controllers;

use App\Traits\TemporaleTrait;
use App\Traits\ReturnTrait;
use App\Traits\StoreTrait;
use App\Traits\StockTrait;
use App\Traits\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\CashReturn;
use App\Models\CashReturnDetail;
use Illuminate\Support\Facades\Auth;
use DB;

class CashReturnController extends Controller
{

    use TemporaleTrait;
    use StockTrait;
    use StoreTrait;
    use StoreProductTrait;
    use ReturnTrait;

    // public function create(Request $request)
    // {

    //     $data = $request->post('return_cash');



    //     // -------------------------------------------- this check if qty_return greater than supplied quantity -----------------------------------------------------

    //     foreach ($data as  $value) {

    //         //  qty_remain = qty_supply - qty_return
    //         if ($value['qty_remain'] > $value['qty']) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المنصرفه"]);
    //         } 
    //         elseif ($value['qty_remain'] == 0) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
    //         }
    //     }

    //     // return response()->json($request->post('return_cash'));
    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //     $cash_return = new CashReturn();
    //     $cash_return->cash_id = $request->post('cash_id');
    //     $cash_return->date  = $request->post('date');
    //     $cash_return->quantity = $request->post('total');
    //     $cash_return->note  = $request->post('note');
    //     $cash_return->save();

    //     DB::table('cashes')
    //         ->where('id', $request->post('cash_id'))
    //         ->increment('qty_return', $request->post('total'));


    //     foreach ($request->post('return_qty') as $key_qty => $value_qty) {
    //         if ($value_qty != null) {
    //             foreach ($data as $value) {


    //                 if ($value_qty['product_id'] == $value['product_id'] && $value_qty['store_id'] == $value['store_id'] && $value_qty['status_id'] == $value['status_id'] && $value_qty['desc'] == $value['desc']) {

    //                     $stock_f = 0;
    //                     $store_product_f = 0;


    //                     // --------------------------------------------------------------------------------------------------------------

    //                     $store_product_f = $this->refresh_store($value,'return_cash','increment') ;

                    
    //                     // --------------------------------------------------------------------------------------------------------------
    //                     $id_store_product =$this->get($value);
  


    //                     foreach ($id_store_product as $values) {

    //                         $id_store_product = $this->init_store($value,'return_cash');

    //                         // $id_store_product = $values['id'];
    //                     }


    //                     // --------------------------------------------------------------------------------------------------------------

    //                     $this->init_details($cash_return->id,$id_store_product,$value,'return_cash',$request->all());

    //                     // -------------------------------------------------------------------------------------------------

    //                     CashDetail::wherecash($value)->increment('qty_return', $value_qty['qty']);

    //                     // -------------------------------------------------------------------------------------------------
    
    //                      $stock_f=$this->refresh_stock($cash_return->id,$value,'return_cash','increment');


    //                     // -------------------------------------------------------------------------------------------------



    //                     if ($stock_f == 0) {

    //                         $this->init_stock($cash_return->id,$value,'return_cash',$request->post('date'));

    //                     }
    //                     // -------------------------------------------------------------------------------------------------
    //                 }
    //             }
    //         }
    //     }




    //     return response()->json($cash_return);
    // }

    public function show($id)
    {


        $return_cashes = DB::table('cash_returns')->where('cash_returns.cash_id',$id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->select('cash_returns.*', 'cash_returns.date as return_date', 'cash_returns.id as return_id', 'cash_returns.quantity as quantity_return', 'cashes.*')
            ->get();

        return response()->json(['return_cashes' => $return_cashes]);
    }


    public function return_cash_detail($id)
    {


        $return_details = DB::table('cashes')->where('cash_return_details.cash_return_id',$id)
            
            ->join('cash_returns', 'cash_returns.cash_id', '=', 'cashes.id')
            ->join('cash_return_details', 'cash_returns.id', '=', 'cash_return_details.cash_return_id')
           

            ->join('products', 'cash_return_details.product_id', '=', 'products.id')
            ->join('statuses', 'cash_return_details.status_id', '=', 'statuses.id')
            ->join('stores', 'cash_return_details.store_id', '=', 'stores.id')            
            ->select('cash_return_details.*', 'cash_return_details.quantity as qty_return', 'cash_returns.*','statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'products.text as product')
            ->get();

        return response()->json(['return_details' => $return_details]);
        
    }

    public function return_invoice($id)
    {


        $cash_returns = CashReturn::where('cash_returns.id', $id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->select('cashes.*', 'cashes.id as cash_id', 'customers.*', 'cash_returns.*', 'cash_returns.id as return_id')
            ->get();



        $cash_return_details = CashReturnDetail::where('cash_return_details.cash_return_id', $id)
            ->join('cash_returns', 'cash_returns.id', '=', 'cash_return_details.cash_return_id')
            // ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            // ->join('cash_details', 'cashes.id', '=', 'cash_details.cash_id')
            ->join('store_products', 'store_products.id', '=', 'cash_return_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')

            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select('cash_return_details.*', 'cash_return_details.quantity as qty_return', 'cash_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store','products.text as product')
            ->get();

        $users = Auth::user();

        return response()->json(['cash_return_details' => $cash_return_details, 'cash_returns' => $cash_returns, 'users' => $users]);
    }
}
