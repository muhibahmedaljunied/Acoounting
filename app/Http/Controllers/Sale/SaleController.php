<?php

namespace App\Http\Controllers\Sale;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Services\InventureService;
use App\Services\SaleService;
use App\Traits\Unit\UnitsTrait;
use App\Models\Sale;
use DB;
class SaleController extends Controller
{
    use InvoiceTrait,
    UnitsTrait,
        GeneralTrait;


    public function __construct(
        protected InventureService $inventury,
        protected CoreService $core,
        protected StockRepositoryInterface $stock,
        protected DetailRepositoryInterface $details,
        protected DailyService $daily,
        protected SaleService $sale,
    ) {

     
    }

   
    public function index(Request $request)
    {

        [$products, $units] = ($request->id) ? $this->get_one($request) : $this->get_all($request);


        $customers = DB::table('customers')
            ->join('customer_accounts', 'customer_accounts.customer_id', '=', 'customers.id')
            ->select('customers.id', 
            'customers.name', 
            'customer_accounts.account_id')
            ->get();

        $treasuries = DB::table('treasuries')
            ->join('treasury_accounts', 'treasury_accounts.treasury_id', '=', 'treasuries.id')
            ->select('treasuries.id', 
            'treasuries.name', 
            'treasury_accounts.account_id')
            ->get();

        // $temporales = $this->one_temporale('sale');


        return response()->json([
            'products' => $products,
            'units' => $units,
            'customers' => $customers,
            // 'temporales' => $temporales,
            'treasuries' => $treasuries,

        ]);
    }

    public function get_all()
    {

        $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select('products.*', 
            'products.text as product', 
            'stores.text as store', 
            'statuses.name as status', 
            'store_products.quantity as availabe_qty', 
            'store_products.*',
            'store_products.id as store_product_id')
            ->paginate(100);
        $units = $this->units($products);

        return [$products, $units];
    }
    public function get_one($request)
    {

        $retVal = ($request->type == 'product') ? 'store_products.product_id' : 'store_products.store_id';
        $products = StoreProduct::where($retVal, $request->id)
            ->where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select('products.*', 
            'products.text as product', 
            'stores.text as store', 
            'statuses.name as status', 
            'store_products.quantity as availabe_qty', 
            'store_products.*',
            'store_products.id as store_product_id')
            ->paginate(100);
        $units = $this->units($products);
        return [$products, $units];
    }
    

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
                'message' => "sale created successfully",
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





    public function show(Request $request)
    {
        $sales = DB::table('sales')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('payment_sales', 'payment_sales.sale_id', '=', 'sales.id')
            ->select('sales.*', 
            'sales.id as sale_id', 
            'customers.*', 
            'payment_sales.*')
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


    // public function destroy(Request $request)
    // {
    //     if ($request->id) {
    //         Temporale::where('type_process', 'sale')->where('temporales.product_id', $request->id)->delete();
    //     } else {
    //         Temporale::where('type_process', 'sale')->delete();
    //     }


    //     return response()->json('successfully deleted');
    // }
}
