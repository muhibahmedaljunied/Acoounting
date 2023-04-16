<?php

namespace App\Http\Controllers;

use App\Models\PayableNote;
use App\Traits\TemporaleTrait;
use App\Traits\InvoiceTrait;
use App\Traits\DetailsTrait;
use Illuminate\Foundation\Auth\Access\store as s;

use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;
use App\Models\PaymentPurchase;
use App\Models\StoreProduct;
use App\Models\Supplier;
use DB;
use Illuminate\Support\Facades\Auth;


class PayableNoteController extends Controller
{
    use TemporaleTrait, InvoiceTrait, DetailsTrait,s;

    public function index()
    {

        $payable_notes = DB::table('payable_notes')
        ->join('purchases', 'purchases.id', '=', 'payable_notes.purchase_id')
        ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
        ->select('purchases.*', 'payment_purchases.*','payable_notes.*')
        ->get();
    return response()->json(['payable_notes' => $payable_notes]);

        
    }



    public function store(Request $request)
    {
        // return response()->json(['payable_note' => $request->all()]);

         
        $payment = PaymentPurchase::find($request->id);

        if($request->post('total_remaining') == 0 ){ 
            $array_data =['payment_status' =>'paiding','paid'=>$request->post('remaining') - $request->post('total_remaining'),'remaining'=>$request->post('total_remaining')];
        }
        if($request->post('total_remaining') > 0 ){ 
            $array_data =['payment_status'=>'Partialy','paid'=>$request->post('remaining') - $request->post('total_remaining'),'remaining'=>$request->post('total_remaining')];
        }  
        // return response()->json(['payable_note' => $array_data]);
        $payment->update($array_data);

// ------------------------------------------------------------------------------------------------
        $payable_note = new PayableNote();
        $payable_note->purchase_id = $request->post('purchase');
        $payable_note->date = $request->post('date');
        $payable_note->paid = $request->post('paid');

        $payable_note->save();
     

        return response()->json(['payable_note' => $payable_note]);





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
