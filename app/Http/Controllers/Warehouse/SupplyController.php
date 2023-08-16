<?php

namespace App\Http\Controllers\Warehouse;

use App\Traits\GeneralTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use App\Models\StoreProduct;
use App\Models\Product;
use App\Models\Supply;
use App\Models\SupplyDetail;
use App\Models\Store;
use App\Models\Status;
use App\Models\Unit;
use App\Models\Temporale;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\TemporaleRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\InventureService;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

use App\Models\Supplier;

use Illuminate\Http\Request;
use DB;

class SupplyController extends Controller
{

    use TemporaleTrait, InvoiceTrait, DetailsTrait, GeneralTrait;

    public function __construct(protected StockRepositoryInterface $stock,
                                protected TemporaleRepositoryInterface $temporale,
                                protected DetailRepositoryInterface $details,
                                protected InventureService $inventury)
    {
        $this->inventury = $inventury;
        $this->stock = $stock;
        $this->temporale = $temporale;
    }

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

    public function store(Request $request)
    {

        // return response()->json(['message' => $request->all()]);
        foreach ($request->post('count') as $value) {

            $temporale_f = 0;
            // if ($value !== null) {


            $temporale_f = tap(Temporale::whereall($request->all(), $value, $request->post('type')))
                ->update(['qty' => $request->post('qty')[$value], 'price' => $request['price'][$value]])
                ->get('id');


            if (count($temporale_f) == 0) {

                $this->temporale->add_temporale($request->all(),$value);
            }

            // }
        }


        return response()->json(['message' => $request->all()]);
    }


    public function payment(Request $request)
    {



        $supply_id =  $this->stock->add($request->all());
        $temporale = $this->check_temporale($request->post('type'));
        
        if ($temporale != 0) {


            foreach ($temporale as $value) {

                $stock_f = 0;
                $store_product_f = 0;

                $store_product_f = $this->refresh_store(
                    data: $value,

                ); // this make updating for store_products
              
                $id_store_product = $this->get($value);  //this get data from store_products
                //----------------------------------------------------------------------------------------------------------------------------------------- 
                if ($store_product_f == 0) {

                    $id_store_product = $this->init_store(
                        data: $value,
                    );


                    // $id_store_product = $this->init_store(value:$value, type:$request->post('type')); // this make intial for store_products if it is empty
                }

                $this->details->init_details(
                    id: $supply_id,
                    id_store_product: $id_store_product,
                    data: $value,

                ); // this make initial for details tables

                $this->inventury->refresh_price($id_store_product); //this make refresh for cost of product


                $stock_f = $this->refresh_stock(
                    id: $supply_id,
                    data: $value,

                ); // this make update for stock table

                if ($stock_f == 0) {

                    $this->init_stock(
                        id: $supply_id,
                        data: $value,

                    ); //this make intial for stock table if it is empty 
                }
            }

            Temporale::where('type_process', $request->post('type'))->delete(); //this removes data from temporale table after moving it 
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'faild']);
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
        $unit = Unit::all();

        $users = Auth::user();




        return response()->json(['product' => $product, 'supplier' => $supplier, 'store' => $store, 'status' => $status, 'unit' => $unit, 'users' => $users]);
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

    public function invoice_supply(Request $request, $id)
    {


        $table = $request->post('table');


        $supplies = Supply::where('supplies.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*')
            ->get();
        $details = $this->invoice($id, $table);

        $users = Auth::user();


        return response()->json([$table => $details, 'supplies' => $supplies, 'users' => $users]);
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

        // return response()->json(['repomovement' =>$request->all()]);

        if ($request->post('type_operation') == 2) {
            $type_operation = 'Cash';
        }
        if ($request->post('type_operation') == 3) {
            $type_operation = 'Supply';
        }
        if ($request->post('type_operation') == 4) {
            $type_operation = 'CashReturn';
        }
        if ($request->post('type_operation') == 5) {
            $type_operation = 'SupplyReturn';
        }

        if ($request->post('type_operation') == 6) {
            $type_operation = 'Sale';
        }

        if ($request->post('type_operation') == 7) {
            $type_operation = 'Purchase';
        }

        if ($request->post('type_operation') == 8) {
            $type_operation = 'SaleReturn';
        }
        if ($request->post('type_operation') == 9) {
            $type_operation = 'PurchaseReturn';
        }


        if ($request->post('type_operation') == 1) {

            $repomovement = Stock::where($all)
                // ->where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status', 'units.name as unit')
                ->get();

            $users = Auth::user();
            return response()->json(['repomovement' => $repomovement, 'users' => $users]);
        }

        if (!empty($all)) {

            $repomovement = Stock::where($all)
                ->where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status', 'units.name as unit')
                ->get();
        } else {
            $repomovement = Stock::where('stocks.type_operation', $type_operation)
                ->whereBetween('stocks.date', array($request->post('from_date'), $request->post('to_date')))
                ->joinstock()
                ->select('stocks.*', 'stocks.quantity as qty_stock', 'products.text as product', 'stores.*', 'stores.text as store', 'statuses.name as status', 'units.name as unit')
                ->get();
        }


        return response()->json(['repomovement' => $repomovement]);
    }

    public function repo_stock(Request $request)
    {


        $all = [];
        $all = $this->all_condition($request, 'store_products');
        // return response()->json(['repostocks' => $all]);

        if (!empty($all)) {

            $repostocks = StoreProduct::where($all)
                ->where('store_products.quantity', '!=', 0)->where('product_units.unit_type', '==', 0)
                ->joinall()
                ->join('product_units', 'product_units.product_id', '=', 'products.id')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->select('products.text as product', 'store_products.*', 'stores.*', 'statuses.name as status', 'units.name as unit')
                ->get();

            foreach ($repostocks as $value) {

                $units = DB::table('product_units')
                    ->join('units', 'units.id', '=', 'product_units.unit_id')
                    ->join('products', 'products.id', '=', 'product_units.product_id')
                    ->where('product_units.product_id', $value->product_id)
                    ->select('units.*', 'products.rate', 'product_units.unit_type', 'products.rate')
                    ->get();

                $value->units = $units;
            }
        } else {

            $repostocks = StoreProduct::where('store_products.quantity', '!=', 0)->where('product_units.unit_type', '==', 0)
                ->joinall()
                ->join('product_units', 'product_units.product_id', '=', 'products.id')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->select('products.text as product', 'store_products.*', 'stores.*', 'stores.text as store', 'statuses.name as status', 'products.rate', 'units.name as unit')
                ->get();


            foreach ($repostocks as $value) {

                $units = DB::table('product_units')
                    ->join('units', 'units.id', '=', 'product_units.unit_id')
                    ->join('products', 'products.id', '=', 'product_units.product_id')
                    ->where('product_units.product_id', $value->product_id)
                    ->select('units.*', 'products.rate', 'product_units.unit_type')
                    ->get();

                $value->units = $units;
            }
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

    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'supply')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'supply')->delete();
        }


        return response()->json('successfully deleted');
    }
}
