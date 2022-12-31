<?php

namespace App\Http\Controllers;
use App\Traits\TemporaleTrait;
use App\Traits\StoreTrait;
use App\Traits\ReturnTrait;
use App\Traits\StockTrait;
use App\Traits\StoreProductTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\SupplyReturn;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;
class SupplyReturnController extends Controller
{

    use TemporaleTrait,StoreTrait,StockTrait,StoreProductTrait,ReturnTrait;

    // public function create(Request $request)
    // {

    //     $data = $request->post('old');
    //     $return = $request->post('return_qty');

    //     // return response()->json(['data'=> $data,'return'=>$return]);


    //     // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

    //     foreach ($data as  $value) {

    //         if ($value['qty_remain'] > $value['avilable_qty']) {


    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"]);
    //         } elseif ($value['qty_remain'] > $value['qty']) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المورده"]);
    //         } elseif ($value['qty_remain'] == 0) {

    //             return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
    //         }
    //     }


    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //     $supply_return = new SupplyReturn();
    //     $supply_return->supply_id = $request->post('supply_id');
    //     $supply_return->date  = $request->post('date');
    //     $supply_return->quantity = $request->post('total');
    //     $supply_return->note  = $request->post('note');
    //     $supply_return->save();

    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //     DB::table('supplies')
    //         ->where('id', $request->post('supply_id'))
    //         ->increment('qty_return', $request->post('total'));

    //     // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //     foreach ($return as $key_qty => $value_qty) {

    //     return response()->json(['data'=> $value_qty]);

    //         if ($value_qty != null) {


    //             foreach ($data as  $value) {

    //                 if ($value_qty['product_id'] == $value['product_id'] && $value_qty['store_id'] == $value['store_id'] && $value_qty['status_id'] == $value['status_id'] && $value_qty['desc'] == $value['desc'] ) {

    //                     // -------------------------------------------------------------------------------------------------
    //                     $stock_f = 0;
    //                     $store_product_f = 0;

    //                     $store_product_f = $this->refresh_store($value,'return_supply','decrement');

    //                     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //                     $id_store_product = $this->get($value);


    //                     foreach ($id_store_product as $values) {


    //                         $id_store_product = $values['id'];
    //                     }

    //                     if ($store_product_f == 0) {

    //                         $id_store_product = $this->init_store($value,'return_supply');
    //                         // return response()->json(['id_store_product'=>'muhib']);


    //                     }

    //                     // return response()->json(['id_store_product'=> $id_store_product]);

    //                     //----------------------------------------------------------------------------------------------------------------------------------------- 
    //                     $this->init_details($supply_return->id,$id_store_product,$value,'return_supply',$request->all());

    //                     // -------------------------------------------------------------------------------------------------

    //                     SupplyDetail::wheresupply($value)->increment('qty_return', $value_qty['qty']);

    //                     // -------------------------------------------------------------------------------------------------

    //                     $stock_f = $this->refresh_stock($supply_return->id, $value, 'return_supply', 'decrement');
                   
    //                     // -------------------------------------------------------------------------------------------------


    //                     if ($stock_f == 0) {

    //                         $this->init_stock($supply_return->id, $value,'return_supply', $request->post('date'));

    //                     }

    //                     // -------------------------------------------------------------------------------------------------
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json($request->post('total'));
    // }

    public function get_data_for_report()
    {

        $product = Product::all();
        $store = Store::all();
        $supplier = Supplier::all();

        return response()->json(['product' => $product, 'supplier' => $supplier, 'store' => $store]);
    }





    public function show($id)
    {



        $return_supplies = DB::table('supply_returns')->where('supply_returns.supply_id', $id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->select('supply_returns.*', 'supply_returns.date as return_date', 'supply_returns.quantity as quantity_return', 'supply_returns.id as return_id', 'supplies.*')
            ->get();

        return response()->json(['return_supplies' => $return_supplies]);
    }


    public function return_supply_detail($id)
    {


        $return_details = DB::table('supplies')->where('supply_return_details.supply_return_id', $id)


            ->join('supply_returns', 'supply_returns.supply_id', '=', 'supplies.id')
            ->join('supply_return_details', 'supply_returns.id', '=', 'supply_return_details.supply_return_id')

            // ->join('store_products', 'store_products.id', '=', 'supply_return_details.store_product_id')
            ->join('products', 'supply_return_details.product_id', '=', 'products.id')
            ->join('statuses', 'supply_return_details.status_id', '=', 'statuses.id')
            ->join('stores', 'supply_return_details.store_id', '=', 'stores.id')
            ->select('supply_return_details.*', 'supply_return_details.quantity as qty_return', 'supply_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'products.text as product')
            ->get();

        return response()->json(['return_details' => $return_details]);
    }


    public function return_invoice($id)
    {

        $return_supplies = SupplyReturn::where('supply_returns.id', $id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*', 'supply_returns.*', 'supply_returns.id as return_id')
            ->get();



        $return_details = DB::table('supplies')->where('supply_return_details.supply_return_id', $id)

            ->join('supply_returns', 'supply_returns.supply_id', '=', 'supplies.id')
            ->join('supply_return_details', 'supply_returns.id', '=', 'supply_return_details.supply_return_id')

            // ->join('store_products', 'store_products.id', '=', 'supply_return_details.store_product_id')

            ->join('products', 'supply_return_details.product_id', '=', 'products.id')
            ->join('statuses', 'supply_return_details.status_id', '=', 'statuses.id')
            ->join('stores', 'supply_return_details.store_id', '=', 'stores.id')
            ->select('supply_return_details.*', 'supply_return_details.quantity as qty_return', 'supply_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'products.text as product')
            ->get();

        $users = Auth::user();

        return response()->json(['return_details' => $return_details, 'return_supplies' => $return_supplies, 'users' => $users]);
    }



    public function data_for_supplyreturn()
    {

        $supplier = Supplier::all();

        $category = Category::all();

        return response()->json(['supplier' => $supplier, 'category' => $category]);
    }

    public function reposupplyreturn_by_supplier(Request $request)
    {

        // DB::enableQueryLog();





        if ($request->post('supplier_id') != 0) {

            $s = ['supplies.supplier_id', $request->post('supplier_id')];
        }

        if ($request->post('product_id') != 0) {

            $s = ['supply_return_details.product_id', $request->post('product_id')];
        }



        // where([$s,$p,$st])

        $reposupplyreturn = DB::table('supply_returns')->where([$s])
            ->whereBetween('supply_returns.date', array($request->post('from_date'), $request->post('to_date')))
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->join('supply_return_details', 'supply_return_details.supply_return_id', '=', 'supply_returns.id')
            ->join('products', 'products.id', '=', 'supply_return_details.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('stores', 'stores.id', '=', 'store_products.store_id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('supply_returns.*', 'supply_return_details.*', 'categories.name as category_name', 'group_categories.name as group_name', 'products.text as product', 'products.status', 'suppliers.name as first_name', 'suppliers.last_name')
            ->get();


        return response()->json(['reposupplyreturn' => $reposupplyreturn]);
        // return response()->json(DB::getQueryLog());
    }
}
