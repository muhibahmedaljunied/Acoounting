<?php

namespace App\Http\Controllers;

use App\Traits\TemporaleTrait;
use App\Traits\InvoiceTrait;
use App\Traits\DetailsTrait;
use Illuminate\Foundation\Auth\Access\store as s;

use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;
use App\Models\PaymentPurchase;
use App\Models\ReceivableNote;
use App\Models\StoreProduct;
use App\Models\Supplier;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpParser\Node\Stmt\Foreach_;

class ReceivableNoteController extends Controller
{
    use TemporaleTrait, InvoiceTrait, DetailsTrait,s;

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


    public function store(Request $request)
    {

        
        // $payment = ReceivableNote::find($request->id);
        // if($request->post('total_remaining') == 0 ){ 
        //     $array_data =['payment_status' =>'paiding','paid'=>1212,'remaining'=>1212];
        // }
        // if($request->post('total_remaining') > 0 ){ 
        //     $array_data =['payment_status','Partialy'];
        // }

        // $payment->update($array_data);
    }

    public function get_all_newsale()
    {
    }
    public function payment_bond(Request $request){

        $purchase_detail = DB::table('purchases')
            ->where('purchases.id',$request->id)
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select('purchases.*', 'purchases.id as purchases_id', 'suppliers.*', 'payment_purchases.*')
            ->get();
        return response()->json(['purchase_detail' => $purchase_detail]);

    }
    // public function payment_bond_store(Request $request){


    //     $payment = PaymentPurchase::find($request->id);
    //     if($request->post('total_remaining') == 0 ){ 
    //         $array_data =['payment_status' =>'paiding','paid'=>1212,'remaining'=>1212];
    //     }
    //     if($request->post('total_remaining') > 0 ){ 
    //         $array_data =['payment_status','Partialy'];
    //     }

    //     $payment->update($array_data);

    // }
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
  
    public function invoice_purchase($id,$table = 'purchase_details')
    {
 
        $purchases = Purchase::where('purchases.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'purchases.*')
            ->get();

        $details = $this->invoice($id,$table);

      

        $users = Auth::user();


        return response()->json([$table => $details, 'purchases' => $purchases, 'users' => $users]);
    }
    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'purchase')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'purchase')->delete();
        }


        return response()->json('successfully deleted');
    }
}
