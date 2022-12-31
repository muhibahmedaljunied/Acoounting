<?php

namespace App\Http\Controllers;

use App\Traits\ConditionTrait;
use App\Traits\TemporaleTrait;
use App\Models\StoreProduct;
use Illuminate\Foundation\Auth\Access\store as s;
use App\Models\Product;
use App\Models\Supply;
use App\Models\SupplyDetail;
use App\Models\Store;
use App\Models\Status;
use App\Models\Temporale;

use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

use App\Models\Supplier;

use Illuminate\Http\Request;
use DB;

class SupplyController extends Controller
{

    use TemporaleTrait, ConditionTrait,s;
    public function index()
    {

        $products = DB::table('products')
            ->select('products.*',)
            ->get();


        $statuses = Status::all();


        // ----------------------------------------------------------------------------------------------
        $stores = DB::table('stores')
            ->select('stores.*')
            ->get();

        // ----------------------------------------------------------------------------------------------

        $suppliers = Supplier::all();

        $temporales = $this->one_temporale('supply');

        return response()->json(['products' => $products, 'suppliers' => $suppliers, 'temporales' => $temporales, 'statuses' => $statuses, 'stores' => $stores]);
    }

    public function search_new(Request $request)
    {


        $products = Product::where('products.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'group_categories.name as group_name')
            ->paginate(1000);


        return response()->json(['products' => $products]);
    }

    public function create()
    {
        $product = Product::all();
        // $unit = Unit::all();
        $store = Store::all();

        return response()->json(['product' => $product, 'unit' => $unit, 'store' => $store]);
    }

    public function get_data_for_report()
    {

        $product = Product::all();
        $store = Store::all();
        $supplier = Supplier::all();
        $status = Status::all();


        $users = Auth::user();




        return response()->json(['product' => $product, 'supplier' => $supplier, 'store' => $store, 'status' => $status, 'users' => $users]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $supplies = DB::table('supplies')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*')
            ->paginate(1000);

        return response()->json(['supplies' => $supplies]);
    }

    public function search(Request $request)
    {

        $supplies = Supply::where('suppliers.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*')
            ->paginate(1000);

        return response()->json(['supplies' => $supplies]);
    }

    public function details_supply($id)
    {
        // $supply_details = SupplyDetail::where('supply_details.supply_id', $id)
        $supply_details = StoreProduct::where('supply_details.supply_id', $id)
            ->join('supply_details', 'store_products.id', '=', 'supply_details.store_product_id')
            ->joinall()
            ->select('products.*', 'products.text as product', 'supply_details.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', 'store_products.quantity as avilable_qty', DB::raw('supply_details.qty-supply_details.qty_return AS qty_remain'))
            ->get();

        return response()->json(['supply_details' => $supply_details]);
    }

    public function invoice_supply($id)
    {


        $supplies = Supply::where('supplies.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*')
            ->get();

        $supply_details = SupplyDetail::where('supply_details.supply_id', $id)
            // ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', 'supply_details.store_product_id')
            ->joinall()
            ->select('products.*','products.text as product', 'supply_details.*', 'statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'store_products.quantity as avilable_qty', DB::raw('supply_details.qty-supply_details.qty_return AS qty_remain'))
            ->get();


        $users = Auth::user();


        return response()->json(['supply_details' => $supply_details, 'supplies' => $supplies, 'users' => $users]);
    }


    public function data_for_supply()
    {

        $supplier = Supplier::all();
        // $category = Category::all();

        return response()->json(['supplier' => $supplier]);
    }



    public function reposupply_by_supplier(Request $request)
    {

        $all = [];
        $all = $this->all_condition($request, 'supply_details');
        if ($request->post('supplier')) {

            $s6 = ['supplies.supplier_id', $request->post('supplier')];
            $all[5] = $s6;
        }

        // dd($all);

        if (!empty($all)) {
            $reposupply = SupplyDetail::where($all)
                ->whereBetween('date', array($request->post('from_date'), $request->post('to_date')))
                ->joinsupply()
                ->select('supplies.*', 'supply_details.*', 'supply_details.qty as qty', 'products.text as product', 'statuses.name as status', 'stores.text as store')
                ->get();
        } else {

            $reposupply = SupplyDetail::whereBetween('date', array($request->post('from_date'), $request->post('to_date')))
                ->joinsupply()
                ->select('supplies.*', 'supply_details.*', 'supply_details.qty as qty', 'products.text as product', 'statuses.name as status', 'stores.text as store')
                ->get();
        }

        $users = Auth::user();

        return response()->json(['reposupply' => $reposupply]);



        // return response()->json(DB::getQueryLog());
    }

    public function repo_movement(Request $request)
    {


        $type_operation = 0;
        $all = [];
        $all = $this->all_condition($request, 'stocks');

        if ($request->post('type_operation') == 2) {
            $type_operation = 'cash';
        }
        if ($request->post('type_operation') == 3) {
            $type_operation = 'supply';
        }
        if ($request->post('type_operation') == 4) {
            $type_operation = 'return_cash';
        }
        if ($request->post('type_operation') == 5) {
            $type_operation = 'return_supply';
        }

        if ($request->post('type_operation') == 1) {

            $repomovement = Stock::where($all)
                // ->where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status')
                ->get();

            $users = Auth::user();
            return response()->json(['repomovement' => $repomovement, 'users' => $users]);
        }

        if (!empty($all)) {

            $repomovement = Stock::where($all)
                ->where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status')
                ->get();
        } else {
            $repomovement = Stock::where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status')
                ->get();
        }


        return response()->json(['repomovement' => $repomovement]);
    }

    public function repo_stock(Request $request)
    {


        $all = [];
        $all = $this->all_condition($request, 'store_products');
        // dd($all);

        if (!empty($all)) {

            $repostocks = StoreProduct::where($all)
                ->where('store_products.quantity', '!=', 0)
                ->joinall()
                ->select('products.text as product', 'store_products.*', 'stores.*', 'statuses.name as status')
                ->get();
        } else {

            $repostocks = StoreProduct::where('store_products.quantity', '!=', 0)
                ->joinall()
                ->select('products.text as product', 'store_products.*', 'stores.*', 'stores.text as store', 'statuses.name as status')
                ->get();
        }



        $users = Auth::user();

        return response()->json(['repostocks' => $repostocks, 'users' => $users]);
    }



    public function edit(Supply $supply)
    {
        //
    }

    public function update(Request $request, Supply $supply)
    {
        //
    }

    public function destroy(Supply $supply)
    {
        Temporale::where('type_process', 'supply')->delete();


        return response()->json('successfully deleted');
    }
}
