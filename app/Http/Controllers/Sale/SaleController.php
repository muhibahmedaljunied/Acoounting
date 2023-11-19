<?php

namespace App\Http\Controllers\Sale;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Services\DailyService;
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
        Request $request,
        protected WarehouseRepositoryInterface $warehouse,
        protected InventuryStoreRepositoryInterface $store,
        protected InventuryStockRepositoryInterface $stock,
        protected DetailRepositoryInterface $details,
        protected CoreService $core,
        protected DailyService $daily,
        protected SaleService $sale,
        protected UnitService $unit,

    ) {
        $this->core->setData($request->all());
        $this->core->setDiscount($request['discount'] * $request['grand_total'] / 100);
    }


    public function index(Request $request)
    {

        [$products, $units] = ($request->id) ? $this->get_one($request) : $this->get_all($request);

        return response()->json([
            'products' => $products,
            'units' => $units,
            'customers' => $this->customers(),
            'treasuries' => $this->treasuries(),

        ]);
    }

    public function customers()
    {

        $customers = DB::table('customers')
            ->join('accounts', 'customers.account_id', '=', 'accounts.id')
            ->select(
                'customers.*',
                // 'customers.name',
                // 'customer_accounts.account_id'
            )
            ->get();

        return $customers;
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                // 'treasury_accounts.account_id'
            )
            ->get();

     
    }
    public function get_all()
    {

        $products = StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.id as store_product_id'
            )
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
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.id as store_product_id'
            )
            ->paginate(100);
        $units = $this->units($products);
        return [$products, $units];
    }


    public function payment(Request $request)
    {


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

       
            $this->warehouse->add();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
     
                $this->unit->unit_and_qty(); // this make decode for unit and convert qty into miqro

                $this->store->store(); // this handle data in store_product table
               
                $this->details->init_details(); // this make initial for details table
          
                $this->stock->stock(); // this handle data in stock table

            }
         
            $this->sale->pay();
            $this->daily->daily();


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





    public function show()
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




   
}
