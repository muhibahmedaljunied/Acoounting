<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
// use App\Traits\Details\DetailsTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;
use App\Models\PaymentPurchase;
use App\Models\StoreProduct;
use App\Models\Supplier;
use App\Services\InventureService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpParser\Node\Stmt\Foreach_;

class PurchaseController extends Controller
{
    use TemporaleTrait, 
    InvoiceTrait, 
    // DetailsTrait, 
    GeneralTrait;

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

        foreach ($request->post('count') as $value) {

            $temporale_f = 0;
            // if ($value !== null) {

            // ------------------------------------------------------------------------------------------
            $array_unit_after_decode = $request['unit'][$value];
            $micro_unit_qty = $this->set_unit($request, $value, $array_unit_after_decode);
            // ------------------------------------------------------------------------------------------
            $temporale_f = tap(
                Temporale::whereall($request->all(), $value, $request->post('type'))
            )
                ->update([
                    'qty' => $micro_unit_qty,
                    'price' => $request['price'][$value],
                    'tax' => $request['tax'][$value]
                ])
                ->get('id');

            if (count($temporale_f) == 0) {


                $this->add_temporale(
                    request: $request->all(),
                    value: $value,
                    type: $request->post('type')
                );
            }
            // }
        }


        return response()->json(['message' => $request->all()]);
    }



    public function payment(Request $request,InventureService $inventury)
    {

        $discount = $request['discount'] * $request['grand_total'] / 100;

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $purchase_id =  $this->add_start(data: $request->all(),discount:$discount);
            // dd($purchase_id);
            $temporale = $this->check_temporale($request->post('type'));

            if (count($temporale) != 0) {

                $this->payment_purchase(data: $request->all(), id: $purchase_id);

                // ----------------------------------------------------------------------------------------
                foreach ($temporale as $key => $value) {

                    $stock_f = 0;
                    $store_product_f = 0;

                    $data = array_merge($request->all(), $value);
                    // dd($data);
                    $store_product_f = $inventury->refresh_store(data: $data,type_refresh: 'increment'); // this make updating for store_products
                    $id_store_product = $inventury->get($value);  //this get data from store_products
                    // dd($id_store_product);
                    // //----------------------------------------------------------------------------------------------------------------------------------------- 
                    if ($store_product_f == 0) {
                        $id_store_product = $inventury->init_store(data: $data);
                    } // this make intial for store_products if it is empty
                    $this->init_details(id: $purchase_id, id_store_product: $id_store_product, data: $data); // this make initial for details tables

                    $stock_f = $inventury->refresh_stock(id: $purchase_id, data: $data,); // this make update for stock table

                    if ($stock_f == 0) {

                        $inventury->init_stock(id: $purchase_id, data: $data); //this make intial for stock table if it is empty 
                    }
                }

                Temporale::where('type_process', $request->post('type'))->delete(); //this removes data from temporale table after moving it 
                // return response()->json(['message' => 'success']);
            }

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }




        // return response()->json(['message' => 'faild']);
    }



    public function create()
    {
    }

    public function payment_bond(Request $request)
    {

        $payable_note = DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select('purchases.*', 'purchases.id as purchases_id', 'suppliers.*', 'payment_purchases.*')
            ->get();
        return response()->json(['payable_note' => $payable_note]);
    }
    public function payment_bond_store(Request $request)
    {


        $payment = PaymentPurchase::find($request->id);
        if ($request->post('total_remaining') == 0) {
            $array_data = ['payment_status' => 'paiding', 'paid' => 1212, 'remaining' => 1212];
        }
        if ($request->post('total_remaining') > 0) {
            $array_data = ['payment_status', 'Partialy'];
        }

        $payment->update($array_data);
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

    public function invoice_purchase($id, $table = 'purchase_details')
    {

        $purchases = Purchase::where('purchases.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'purchases.*')
            ->get();

        $details = $this->invoice($id, $table);



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





    // $data = array(
    //     'product_id' => $value['product_id'],
    //     'status_id' => $value['status_id'],
    //     'unit_id' => $value['unit_id'],
    //     'desc' => $value['desc'],
    //     'price' => $value['price'],
    //     'tax' => $value['tax'],
    //     'sub_total' => $value['sub_total'],
    //     'total' => $value['total'],
    //     'store_id' => $value['store_id'],
    //     'qty' => $value['micro_unit_qty'],
    //     'type' => $request['type'],
    //     'type_refresh' => $request['type_refresh'],
    //     'date' => $request['date'],
    // );

}
