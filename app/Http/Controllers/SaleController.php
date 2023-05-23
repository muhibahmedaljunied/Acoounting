<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\GeneralTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
// use App\Traits\Details\DetailsTrait;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Temporale;
use App\Models\Sale;
use App\Models\StoreProduct;
use App\Services\InventureService;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class SaleController extends Controller
{
    use TemporaleTrait,
        InvoiceTrait,
        //  DetailsTrait, 
        GeneralTrait;

       
    public function index(Request $request)
    {

        if ($request->id) {
            $products = StoreProduct::where('store_products.product_id', $request->id)
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
                    ->select('units.*', 'products.rate', 'product_units.unit_type')
                    ->get();

                $value->units = $units;
            }
        } else {
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
                    ->select('units.*', 'products.rate', 'product_units.unit_type')
                    ->get();

                $value->units = $units;
            }
        }


        $customers = Customer::all();
        $temporales = $this->one_temporale('sale');


        return response()->json(['products' => $products, 'units' => $units, 'customers' => $customers, 'temporales' => $temporales]);
    }


    public function store(Request $request)
    {

        // return response()->json(['message' => $request->all()]);

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

                $this->add_temporale(request: $request->all(), value: $value, type: $request->post('type'));
            }
            // }
        }


        return response()->json(['message' => $request->all()]);
    }


    public function payment(Request $request,InventureService $inventure)
    {

        // dd($request->all());
        $discount = $request['discount'] * $request['grand_total'] / 100;

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $sale_id =  $this->add_start(data: $request->all(), discount: $discount);
            $temporale = $this->check_temporale($request->post('type'));

            if (count($temporale) != 0) {

                $this->payment_sale(data: $request->all(), id: $sale_id);

                // ----------------------------------------------------------------------------------------
                foreach ($temporale as $key => $value) {

                    $stock_f = 0;
                    $store_product_f = 0;
                    $data = array_merge($request->all(), $value);
                    $store_product_f = $inventure->refresh_store(data: $data); // this make updating for store_products
                    $id_store_product = $inventure->get($value);  //this get data from store_products

                    // //----------------------------------------------------------------------------------------------------------------------------------------- 
                    if ($store_product_f == 0) {
                        $id_store_product = $inventure->init_store(data: $data);
                    } // this make intial for store_products if it is empty
                    $this->init_details(id: $sale_id, id_store_product: $id_store_product, data: $data); // this make initial for details tables

                    $stock_f = $inventure->refresh_stock(id: $sale_id, data: $data,); // this make update for stock table

                    if ($stock_f == 0) {

                        $inventure->init_stock(id: $sale_id, data: $data); //this make intial for stock table if it is empty 
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



        // $sale_id =  $this->add_start(data: $request->all());
        // $temporale = $this->check_temporale($request->post('type'));
        // if (count($temporale) != 0) {

        //     $this->payment_sale(data: $request->all(), id: $sale_id);

        //     foreach ($temporale as $value) {

        //         $stock_f = 0;
        //         $store_product_f = 0;
        //         $data = array(
        //             'product_id' => $value['product_id'],
        //             'status_id' => $value['status_id'],
        //             'unit_id' => $value['unit_id'],
        //             'desc' => $value['desc'],
        //             'price' => $value['price'],
        //             'tax' => $value['tax'],
        //             'sub_total' => $value['sub_total'],
        //             'total' => $value['total'],
        //             'store_id' => $value['store_id'],
        //             'qty' => $value['micro_unit_qty'],
        //             'type' => $request['type'],
        //             'type_refresh' => $request['type_refresh'],
        //             'date' => $request['date'],
        //         );


        //         $store_product_f = $this->refresh_store(
        //             data: $data,
        //         ); // this make updating for store_products
        //         $id_store_product = $this->get($value);  //this get data from store_products

        //         foreach ($id_store_product as $values) {

        //             $id_store_product = $values['id'];
        //         }
        //         //----------------------------------------------------------------------------------------------------------------------------------------- 
        //         if ($store_product_f == 0) {

        //             $id_store_product = $this->init_store(data: $data);
        //         }

        //         $this->init_details(id: $sale_id, id_store_product: $id_store_product, data: $data); // this make initial for details tables

        //         $stock_f = $this->refresh_stock(data: $data, id: $sale_id); // this make update for stock table

        //         if ($stock_f == 0) {

        //             $this->init_stock(data: $data, id: $sale_id); //this make intial for stock table if it is empty 
        //         }
        //     }

        //     Temporale::where('type_process', $request->post('type'))->delete(); //this removes data from temporale table after moving it 
        //     return response()->json(['message' => 'success']);
        // }

        // return response()->json(['message' => 'faild']);
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


    public function invoice_sale(Request $request, $id)
    {

        $table = $request->post('table');

        $sales = Sale::where('sales.id', $id)
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'users.*')
            ->get();
        $details = $this->invoice($id, $table);

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
