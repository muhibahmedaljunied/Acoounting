<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\Access\Store as s;
use App\Traits\GeneralTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\OpeningInventury;
use App\Models\Temporale;
use App\Models\Status;
use App\Models\ProductUnit;
use App\Models\SaleDetail;
use App\Models\StoreProduct;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class InventuryController extends Controller
{
    use TemporaleTrait, InvoiceTrait, DetailsTrait, GeneralTrait;

    public function index()
    {

        // $temporale = DB::table('opening_inventories') 
        //     ->join('stores', 'opening_inventuries.store_id', '=', 'stores.id')
        //     ->join('statuses', 'opening_inventuries.status_id', '=', 'statuses.id')
        //     ->join('products', 'products.id', '=', 'opening_inventuries.product_id')
        //     ->join('units', 'units.id', '=', 'opening_inventuries.unit_id')
        //     ->select('products.text as product', 'opening_inventuries.qty as tem_qty', 'opening_inventuries.desc', 'opening_inventuries.*', 'stores.text as store', 'statuses.name as status', 'units.name as unit')
        //     ->paginate(20);

        $statuses = Status::all();

        return response()->json([
            // 'temporales' => $temporale, 
            'statuses' => $statuses
        ]);
    }


    public function store(Request $request)
    {


$data = [];
    // dd($request->all());
        // -------------------------------------------------------------------------------------

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            foreach ($request->post('count') as $value) {


               
                dd(array_values($request->all()));
                dd($data);

                $stock_f = 0;
                $store_product_f = 0;
                // $data = array(
                //     'product_id' => $request['product_id'][$value],
                //     'status_id' => $request['status_id'][$value],
                //     'store_id' => $request['store_id'][$value],
                //     'unit_id' => $request['unit_id'][$value],
                //     'qty' => $request['qty'][$value],
                //     'desc' => $request['desc'][$value],
                //     'price' => $request['price'][$value],
                //     'date' => $request['date'][$value],
                //     'total' => $request['total'][$value],
                //     'type' => 'Opening',
                //     'type_refresh' => 'increment',


                // );
           

                $store_product_f = $this->refresh_store(data: $data); // this make updating for store_products

                $id_store_product = $this->get($data);  //this get data from store_products

                // //----------------------------------------------------------------------------------------------------------------------------------------- 
                if ($store_product_f == 0) {
                    $id_store_product = $this->init_store(data: $data);
                } // this make intial for store_products if it is empty

                $r = $this->init_details(
                    id_store_product: $id_store_product,
                    data: $data
                );
                // dd($r);

                $stock_f = $this->refresh_stock(data: $data); // this make update for stock table

                if ($stock_f == 0) {

                    $this->init_stock(data: $data); //this make intial for stock table if it is empty 
                }
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
        // -------------------------------------------------------------------------------------

        return response()->json(['message' => 'success']);
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
