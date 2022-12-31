<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\ConditionTrait;
use App\Traits\TemporaleTrait;
use App\Models\Cash;
use App\Models\CashDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Temporale;
use App\Models\Store;
use App\Models\Status;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class CashController extends Controller
{
    use TemporaleTrait, ConditionTrait, s;
    public function index()
    {
        $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            // ->where('products.notes',0)
            ->select('products.*', 'products.text as product', 'stores.text as store', 'statuses.name as status', 'store_products.quantity as availabe_qty', 'store_products.*')
            ->paginate(100);

        $statuses = Status::all();
        // ----------------------------------------------------------------------------------------------
        $stores = DB::table('stores')
            ->select('stores.*')
            ->get();
        // ----------------------------------------------------------------------------------------------

        $customers = Customer::all();

        $temporales = $this->one_temporale('cash');

        return response()->json(['products' => $products, 'customers' => $customers, 'temporales' => $temporales, 'statuses' => $statuses, 'stores' => $stores]);
    }

    public function search_new(Request $request)
    {

        $products = StoreProduct::where('products.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->joinall()
            ->select('products.*', 'products.text as product', 'statuses.name as status', 'store_products.quantity as availabe_qty', 'store_products.*')
            ->paginate(1000);


        return response()->json(['products' => $products]);
    }


    public function create()
    {
        $product = Product::all();
        // $unit = Unit::all();
        $store = Store::all();
        return response()->json(['product' => $product, 'store' => $store]);
    }

    public function get_data_for_report()
    {

        $product = Product::all();
        $store = Store::all();
        $status = Status::all();
        $users = Auth::user();
        $customer = Customer::all();

        return response()->json([
            'product' => $product,
            'customer' => $customer,
            'store' => $store,
            'status' => $status,
            'users' => $users
        ]);
    }


    public function show()
    {

        $cashes = DB::table('cashes')
            ->select('cashes.*')
            ->paginate(100);

        return response()->json(['cashes' => $cashes]);
    }

    public function details_cash($id)
    {

        // $cash_details = CashDetail::where('cash_details.cash_id', $id)
        $cash_details = StoreProduct::where('cash_details.cash_id', $id)

            ->join('cash_details', 'store_products.id', '=', 'cash_details.store_product_id')
            ->joinall()
            ->select('products.*', 'products.text as product', 'cash_details.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', DB::raw('cash_details.qty-cash_details.qty_return AS qty_remain'))
            ->get();




        return response()->json(['cash_details' => $cash_details]);
    }

    public function invoice_cash($id)
    {

        $cashes = Cash::where('cashes.id', $id)
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->select('cashes.*', 'cashes.id as cash_id', 'customers.*')
            ->get();
        // $cash_details = CashDetail::where('cash_details.cash_id', $id)
        $cash_details = StoreProduct::where('cash_details.cash_id', $id)
            ->join('cash_details', 'store_products.id', '=', 'cash_details.store_product_id')
            ->joinall()
            ->select('products.*', 'products.text as product', 'cash_details.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', DB::raw('cash_details.qty-cash_details.qty_return AS qty_remain'))
            ->get();

        $users = Auth::user();
        return response()->json(['cash_details' => $cash_details, 'cashes' => $cashes, 'users' => $users]);
    }


    public function data_for_cash()
    {

        $customer = Customer::all();
        return response()->json(['customer' => $customer]);
    }



    public function check_qty(Request $request, $id)
    {

        $check_qty = storeProduct::where('store_products.product_id', $id)
            ->select('store_products.quantity')
            ->get();
        return response()->json(['check_qty' => $check_qty]);
    }

    public function repocash_by_customer(Request $request)
    {
        // DB::enableQueryLog();
        $all = [];
        $all = $this->all_condition($request, 'cash_details');

        if ($request->post('customer_id') != 0) {

            $s6 = ['cashes.customer_id', $request->post('customer_id')];
            $all[5] = $s6;
        }

        if (!empty($all)) {
            $repocash =  CashDetail::where($all)
                ->whereBetween('date', array($request->post('from_date'), $request->post('to_date')))
                ->joincash()
                ->select('cashes.*', 'cash_details.*', 'cash_details.qty as qty', 'products.name as product_name', 'statuses.name as status', 'stores.code')
                ->get();
        } else {

            $repocash =  CashDetail::whereBetween('date', array($request->post('from_date'), $request->post('to_date')))
                ->joincash()
                ->select('cashes.*', 'cash_details.*', 'cash_details.qty as qty', 'products.name as product_name', 'statuses.name as status', 'stores.code')
                ->get();
        }


        return response()->json(['repocash' => $repocash]);
        // return response()->json(DB::getQueryLog());
    }


    public function edit()
    {
        //
    }


    public function update()
    {
        //
    }


    public function destroy()
    {
        Temporale::where('type_process', 'cash')->delete();

        return response()->json('successfully deleted');
    }
}
