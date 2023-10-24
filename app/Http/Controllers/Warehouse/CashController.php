<?php

namespace App\Http\Controllers\Warehouse;

use App\Traits\GeneralTrait;

use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use App\Models\Cash;
use App\Models\CashDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Temporale;
use App\Models\Store;
use App\Models\Status;
use App\Models\StoreProduct;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\TemporaleRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CashController extends Controller
{
    use GeneralTrait, DetailsTrait, InvoiceTrait;

    public function __construct(
        protected StockRepositoryInterface $stock,
        protected TemporaleRepositoryInterface $temporale,
        protected DetailRepositoryInterface $details
    ) {
        // $this->inventury = $inventury;
        $this->stock = $stock;
        $this->temporale = $temporale;
    }

    public function index()
    {
        $products = StoreProduct::where('store_products.quantity', '!=', 0)
            ->joinall()
            ->select('products.*', 
            'products.text as product', 
            'products.rate', 
            'stores.text as store', 
            'statuses.name as status', 
            'store_products.quantity as availabe_qty', 
            'store_products.*')
            ->paginate(100);
        $this->units($products);


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
            ->select('products.*', 
            'products.text as product', 
            'statuses.name as status', 
            'store_products.quantity as availabe_qty', 
            'store_products.*')
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
                ->update([
                    'qty' => $request->post('qty')[$value],
                    'price' => $request['price'][$value]
                ])
                ->get('id');


            if (count($temporale_f) == 0) {


                $this->temporale->add_temporale($request->all(), $value);
            }
            // }
        }


        return response()->json(['message' => $request->all()]);
    }
    // public function payment(Request $request)
    // {


    //     $cash_id =  $this->stock->add($request->all());
    //     // -----------------------------------------------here ended-----------------------------------
    //     $temporale = $this->check_temporale($request->post('type'));
    //     // return response()->json(['message' => $temporale]);
    //     if ($temporale != 0) {

    //         foreach ($temporale as $value) {

    //             $stock_f = 0;
    //             $store_product_f = 0;
    //             $store_product_f = $this->refresh_store(
    //                 data: $value,
    //             );
    //             // return response()->json(['message' => $store_product_f]);
    //             $id_store_product = $this->get($value);  //this get data from store_products

    //             //----------------------------------------------------------------------------------------------------------------------------------------- 
    //             if ($store_product_f == 0) {

    //                 $id_store_product = $this->init_store(
    //                     data: $value,
    //                 );
    //             }

    //             $this->details->init_details(
    //                 id: $cash_id,
    //                 id_store_product: $id_store_product,
    //                 data: $value,
    //             ); // this make initial for details tables

    //             $stock_f = $this->refresh_stock(
    //                 id: $cash_id,
    //                 data: $value,
    //             ); // this make update for stock table

    //             if ($stock_f == 0) {

    //                 $this->init_stock(
    //                     id: $cash_id,
    //                     data: $value,
    //                 ); //this make intial for stock table if it is empty 
    //             }
    //         }

    //         Temporale::where('type_process', $request->post('type'))->delete(); //this removes data from temporale table after moving it 
    //         return response()->json(['message' => 'success']);
    //     }

    //     return response()->json(['message' => 'faild']);
    // }


    public function payment(Request $request)
    {

       
    //    dd($request->all());
        $this->core->data = $request->all();
        $this->core->discount = $request['discount'] * $request['grand_total'] / 100;
 
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction
     
            $this->stock->add();
         
         
         
            foreach ($request->post('count') as $value) {

             
                $this->core->value  = $value;
               
                $this->stock->decode_unit()->convert_qty(); 
           
                $this->sale->store();// this handle data in store_product table
   
                $this->details->init_details(); // this make initial for details table
  
                $this->sale->stock();// this handle data in stock table

            }

            $this->payment_sale($this->core);
      
            $this->sale->daily();

            // dd('dddddddd');
         
            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            
     
            return response([
                'message' => "cash created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
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

    public function invoice_cash(Request $request, $id)
    {

        $table = $request->post('table');
        $cashes = Cash::where('cashes.id', $id)
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->select('cashes.*', 'cashes.id as cash_id', 'customers.*')
            ->get();
        $details = $this->invoice($id, $table);

        $users = Auth::user();
        return response()->json([$table => $details, 'cashes' => $cashes, 'users' => $users]);
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
                ->select('cashes.*', 
                'cash_details.*', 
                'cash_details.qty as qty', 
                'products.name as product_name', 
                'statuses.name as status', 
                'stores.code')
                ->get();
        } else {

            $repocash =  CashDetail::whereBetween('date', array($request->post('from_date'), $request->post('to_date')))
                ->joincash()
                ->select('cashes.*', 
                'cash_details.*', 
                'cash_details.qty as qty', 
                'products.name as product_name', 
                'statuses.name as status', 
                'stores.code')
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
