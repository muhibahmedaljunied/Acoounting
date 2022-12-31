<?php

namespace App\Http\Controllers;

use App\Traits\TemporaleTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Purchase;
use App\Models\StoreProduct;
use App\Models\PurchaseDetail;
use Illuminate\Foundation\Auth\Access\store as s;
use App\Models\Supplier;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpParser\Node\Stmt\Foreach_;

class PurchaseController extends Controller
{
    use TemporaleTrait;

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

        $temporales = $this->one_temporale('purchase');

        return response()->json(['products' => $products, 'suppliers' => $suppliers, 'temporales' => $temporales, 'statuses' => $statuses, 'stores' => $stores]);
    }


    public function create()
    {
        
    }

    public function get_all_newsale()
    {
    }
    
    public function show()
    {
        $purchases = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select('purchases.*', 'purchases.id as purchases_id', 'suppliers.*', 'payment_purchases.*')
            ->paginate(10);
        return response()->json(['purchases' => $purchases]);
    }

    public function search(Request $request)
    {

        $products = StoreProduct::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'stores.text as store', 'group_categories.name as group_name')
            ->paginate(10);

        return response()->json(['products' => $products]);
    }

    public function details_purchase($id)
    {
        // return response()->json();
        $purchase_details = PurchaseDetail::where('purchase_details.purchase_id', $id)
            ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', 'purchase_details.store_product_id')
            ->joinpurchase()
            ->select('products.*','products.text as product', 'purchase_details.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw('purchase_details.qty-purchase_details.qty_return AS qty_remain'))
            ->get();


        return response()->json(['purchase_details' => $purchase_details]);
    }

    public function invoice_purchase($id)
    {


        $purchases = Purchase::where('purchases.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'purchases.*')
            ->get();


        $purchase_details = PurchaseDetail::where('purchase_details.purchase_id', $id)
            ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', 'purchase_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select('products.*','products.text as product', 'purchase_details.*', 'statuses.*', 'statuses.name as status', 'stores.*','stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw('purchase_details.qty-purchase_details.qty_return AS qty_remain'))
            ->get();

        $users = Auth::user();


        return response()->json(['purchase_details' => $purchase_details, 'purchases' => $purchases, 'users' => $users]);
    }
    
}
