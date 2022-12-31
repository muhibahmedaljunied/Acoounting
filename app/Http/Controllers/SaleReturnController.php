<?php

namespace App\Http\Controllers;
use App\Traits\TemporaleTrait;
use App\Traits\StoreTrait;
use App\Traits\StockTrait;
use App\Traits\ReturnTrait;

use App\Traits\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\ReturnSaleDetail;
use App\Models\ReturnSale;
use App\Models\SaleDetail;
use DB;
use Illuminate\Support\Facades\Auth;
class SaleReturnController extends Controller
{

    use TemporaleTrait,StockTrait,StoreTrait,StoreProductTrait,ReturnTrait;
  
    public function return_sale_detail($id)
    {


        $return_details = DB::table('sales')->where('return_sale_details.sale_return_id',$id)
            
            ->join('return_sales', 'return_sales.sale_id', '=', 'sales.id')
            ->join('return_sale_details', 'return_sales.id', '=', 'return_sale_details.sale_return_id')
           

            ->join('products', 'return_sale_details.product_id', '=', 'products.id')
            ->join('statuses', 'return_sale_details.status_id', '=', 'statuses.id')
            ->join('stores', 'return_sale_details.store_id', '=', 'stores.id')            
            ->select('return_sale_details.*', 'return_sale_details.qty as qty_return', 'return_sales.*','statuses.*', 'statuses.name as status', 'stores.*', 'products.text as product_name')
            ->get();

        return response()->json(['return_details' => $return_details]);
        
    }


    // public function create(Request $request)
    // {

    //     $data = $request->post('return_sale');
    //     $return = $request->post('return_qty');



    //     // -------------------------------------------- this check if qty_return greater than supplied quantity -----------------------------------------------------

    //     foreach ($data as  $value) {

    //         //  qty_remain = qty_supply - qty_return
    //         if ($value['qty_remain'] > $value['qty']) {


    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المباعه"]);
    //         } elseif ($value['qty_remain'] == 0) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
    //         }
    //     }

    //     // return response()->json($request->post('return_sale'));
    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //     $sale_return = new ReturnSale();
    //     $sale_return->sale_id = $request->post('sale_id');
    //     $sale_return->date  = $request->post('date');
    //     $sale_return->quantity = $request->post('total');
    //     $sale_return->note  = $request->post('note');
    //     $sale_return->save();

    //     DB::table('sales')
    //         ->where('id', $request->post('sale_id'))
    //         ->increment('qty_return', $request->post('total'));


    //     foreach ($request->post('return_qty') as $key_qty => $value_qty) {
    //         if ($value_qty != null) {
    //             foreach ($data as $value) {


    //                 if ($value_qty['product_id'] == $value['product_id'] && $value_qty['store_id'] == $value['store_id'] && $value_qty['status_id'] == $value['status_id'] && $value_qty['desc'] == $value['desc']) {

    //                     $stock_f = 0;
    //                     $store_product_f = 0;


    //                     // --------------------------------------------------------------------------------------------------------------


    //                     $store_product_f =$this->refresh_store($value,'return_sale','increment') ;

    //                     // --------------------------------------------------------------------------------------------------------------

    //                     $id_store_product =$this->get($value);



    //                     foreach ($id_store_product as $values) {


    //                         $id_store_product = $values['id'];
    //                     }



    //                     // --------------------------------------------------------------------------------------------------------------

    //                     $this->init_details($sale_return->id,$id_store_product,$value,'return_sale',$request->all());

    //                     // -------------------------------------------------------------------------------------------------

    //                     $stock_f=$this->refresh_stock($sale_return->id,$value,'return_sale','increment');

    //                     SaleDetail::wheresale($value)->increment('qty_return', $value_qty['qty']);

    //                     // -------------------------------------------------------------------------------------------------

    //                     if ($stock_f == 0) {

    //                         $this->init_stock($sale_return->id,$value,'return_sale',$request->post('date'));

    //                     }
    //                     // -------------------------------------------------------------------------------------------------
    //                 }
    //             }
    //         }
    //     }


    //     return response()->json($sale_return);
    // }

    
    public function show($id)
    {


        $return_sales = DB::table('return_sales')->where('return_sales.sale_id',$id)
            ->join('sales', 'sales.id', '=', 'return_sales.sale_id')
            ->select('return_sales.*', 'return_sales.date as return_date', 'return_sales.id as return_id', 'return_sales.quantity as quantity_return', 'sales.*')
            ->get();


        return response()->json(['return_sales' => $return_sales]);
    }



    public function return_invoice($id)
    {


        $return_sales = ReturnSale::where('return_sales.id', $id)
            ->join('sales', 'sales.id', '=', 'return_sales.sale_id')
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'users.*', 'return_sales.*', 'return_sales.id as return_id')
            ->get();



        $return_sale_details = ReturnSaleDetail::where('return_sale_details.sale_return_id', $id)
            ->join('return_sales', 'return_sales.id', '=', 'return_sale_details.sale_return_id')
            ->join('store_products', 'store_products.id', '=', 'return_sale_details.store_product_id')
            ->joinall()
            ->select('return_sale_details.*', 'return_sale_details.quantity as qty_return', 'return_sales.*', 'statuses.*', 'statuses.name as status', 'stores.*','shelves.*', 'products.name as product_name')
            ->get();

        $users = Auth::user();

        return response()->json(['return_sale_details' => $return_sale_details, 'return_sales' => $return_sales, 'users' => $users]);
    }
}
