<?php

namespace App\Http\Controllers\Warehouse;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\Temporale;
use App\Models\Status;

use DB;


class InventuryController extends Controller
{
    use InvoiceTrait, DetailsTrait, GeneralTrait;
    protected DetailRepositoryInterface $details;
  
    public function index()
    {


        $statuses = Status::all();

        return response()->json([
     
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



                $stock_f = 0;
                $store_product_f = 0;

                $store_product_f = $this->refresh_store(data: $data); // this make updating for store_products

                $id_store_product = $this->get($data);  //this get data from store_products

                if ($store_product_f == 0) {
                    $id_store_product = $this->init_store(data: $data);
                } // this make intial for store_products if it is empty

                $r = $this->details->init_details(
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
            ->select(
                'sales.*',
                'sales.id as sale_id',
                'customers.*',
                'payment_sales.*'
            )
            ->paginate(10);

        return response()->json(['sales' => $sales]);
    }

    public function pricing()
    {

        $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*'
            )
            ->paginate(100);
        $units = $this->units($products);

        return response()->json([
            // 'temporales' => $temporale, 
            'products' => $products
        ]);
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
