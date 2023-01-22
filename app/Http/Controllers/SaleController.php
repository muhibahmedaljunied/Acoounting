<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\ConditionTrait;
use App\Traits\TemporaleTrait;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StoreProduct;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;
class SaleController extends Controller
{
    use TemporaleTrait, ConditionTrait, s;
    public function index()
    {

        $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            // ->where('products.notes',0)
            ->select('products.*', 'products.text as product', 'stores.text as store', 'statuses.name as status', 'store_products.quantity as availabe_qty', 'store_products.*')
            ->paginate(100);


        $customers = Customer::all();

        $temporales = $this->one_temporale('sale');


        return response()->json(['products' => $products, 'customers' => $customers, 'temporales' => $temporales]);
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



    public function details_sale($id)
    {

        $sale_details = SaleDetail::where('sale_details.sale_id', $id)
            ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', 'sale_details.store_product_id')
            ->joinsale()

            ->select('products.*', 'products.text as product', 'sale_details.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw('sale_details.qty-sale_details.qty_return AS qty_remain'))
            ->get();

        return response()->json(['sale_details' => $sale_details]);
    }

    public function invoice_sale($id)
    {

        $sales = Sale::where('sales.id', $id)
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'users.*')
            ->get();

        $sale_details = SaleDetail::where('sale_details.sale_id', $id)
            ->join('store_products', 'store_products.id', '=', 'sale_details.store_product_id')
            ->joinsale()

            ->select('products.*', 'sale_details.*', 'store_products.desc', 'statuses.*', 'statuses.name as status', 'stores.*', DB::raw('sale_details.qty-sale_details.qty_return AS qty_remain'))
            ->get();

        $users = Auth::user();
        return response()->json(['sale_details' => $sale_details, 'sales' => $sales, 'users' => $users]);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
