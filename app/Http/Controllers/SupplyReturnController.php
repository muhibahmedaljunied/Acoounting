<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\SupplyReturn;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use App\Facades\Returns;
use Illuminate\Http\Request;
use DB;

class SupplyReturnController extends Controller
{

    use TemporaleTrait, StockTrait, StoreProductTrait;

    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {



        $request_data = $request->post('old');

        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

        foreach ($request_data as  $key => $value) {


            $result = Returns::check_return($value);

            if ($result['message'] == 0) {

                return response()->json(['message' => 0, 'text' => $result['text']]);
            }
        }
        // -------------------------------------------------------------------------------------------------

        $return = Returns::store_return($request->all());

        // -------------------------------------------------------------------------------------------------

        foreach ($request->post('count') as $value) {
            $data = array_merge($request->all(), $value);
            $data = Returns::create_return($data, $return->id);
        }
        return response()->json(['message' => 'success']);
    }

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


    // public function return_supply_detail($id)
    // {


    //     $return_details = DB::table('supplies')->where('supply_return_details.supply_return_id', $id)


    //         ->join('supply_returns', 'supply_returns.supply_id', '=', 'supplies.id')
    //         ->join('supply_return_details', 'supply_returns.id', '=', 'supply_return_details.supply_return_id')

    //         // ->join('store_products', 'store_products.id', '=', 'supply_return_details.store_product_id')
    //         ->join('products', 'supply_return_details.product_id', '=', 'products.id')
    //         ->join('statuses', 'supply_return_details.status_id', '=', 'statuses.id')
    //         ->join('stores', 'supply_return_details.store_id', '=', 'stores.id')
    //         ->select('supply_return_details.*', 'supply_return_details.quantity as qty_return', 'supply_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'products.text as product')
    //         ->get();

    //     return response()->json(['return_details' => $return_details]);
    // }


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
            ->select('supply_return_details.*', 'supply_return_details.quantity as qty_return', 'supply_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', 'products.text as product')
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
