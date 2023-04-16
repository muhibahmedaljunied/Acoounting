<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\GeneralTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Temporale;
use App\Models\Sale;
use App\Models\ProductUnit;
use App\Models\SaleDetail;
use App\Models\StoreProduct;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class SaleController extends Controller
{
    use TemporaleTrait,InvoiceTrait,DetailsTrait,GeneralTrait;
    
    public function index(Request $request)
    {

        if($request->id){
            $products = StoreProduct::where('store_products.product_id',$request->id )
            ->where('store_products.quantity', '!=', '0')
            ->joinall()
            // ->where('products.notes',0)
            ->select('products.*', 'products.text as product', 'stores.text as store', 'statuses.name as status', 'store_products.quantity as availabe_qty', 'store_products.*')
            ->paginate(100);

        foreach ($products as $value) {

            $units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $value->product_id)
                ->select('units.*','products.rate','product_units.unit_type')
                ->get();

            $value->units = $units;
        }
        }else{
            $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            // ->where('products.notes',0)
            ->select('products.*', 'products.text as product', 'stores.text as store', 'statuses.name as status', 'store_products.quantity as availabe_qty', 'store_products.*')
            ->paginate(100);

        foreach ($products as $value) {

            $units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $value->product_id)
                ->select('units.*','products.rate','product_units.unit_type')
                ->get();

            $value->units = $units;
        }
        }

       



        $customers = Customer::all();

        $temporales = $this->one_temporale('sale');


        return response()->json(['products' => $products, 'units' => $units, 'customers' => $customers, 'temporales' => $temporales]);
    }


    public function create()
    {
    }

    public function get_all_newsale()
    {
    }


    public function show(Request $request)
    {
        $sales = DB::table('sales')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('payment_sales', 'payment_sales.sale_id', '=', 'sales.id')
            ->select('sales.*', 'sales.id as sale_id', 'customers.*', 'payment_sales.*')
            ->paginate(10);

        return response()->json(['sales' => $sales]);
    }

    public function search(Request $request)
    {

        // $sales = Supply::where('users.name', 'LIKE', '%' . $request->post('word_search') . '%')
        //     ->join('users', 'users.id', '=', 'sales.customer_id')
        //     ->select('sales.*', 'sales.id as sale_id', 'users.*')
        //     ->paginate(10);

        // return response()->json(['sales' => $sales]);
    }


    public function invoice_sale(Request $request,$id)
    {

        $table = $request->post('table');

        $sales = Sale::where('sales.id', $id)
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'users.*')
            ->get();
        $details = $this->invoice($id,$table);

        $users = Auth::user();
        return response()->json([$table => $details, 'sales' => $sales, 'users' => $users]);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'sale')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'sale')->delete();
        }


        return response()->json('successfully deleted');
    }
}
