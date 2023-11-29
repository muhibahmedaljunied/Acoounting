<?php

namespace App\Http\Controllers\Sale;
use App\Repository\CheckData\CheckSaleReturnRepository;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StockInventury\StockSaleRepository;
use App\Repository\Stock\SaleRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ReceivableNote;
use App\Models\DailyDetail;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Services\SaleService;
use App\Traits\Unit\UnitsTrait;
use App\Models\Daily;
use App\Services\DailyService;
use App\Models\Sale;

class SaleController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        GeneralTrait;


    public function __construct(
        Request $request,
        protected CoreService $core,


    ) {
        $this->core->setData($request->all());
        $this->core->setDiscount($request['discount'] * $request['grand_total'] / 100);
    }


    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        $this->units($details);

        return response()->json([
            'details' => $details,

        ]);
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
                'customers.name',
                'customers.account_id'
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
                'treasuries.account_id'
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


    public function payment(
        StoreSaleRepository $store,
        StockSaleRepository $stock,
        SaleRepository $warehouse,
        CheckSaleReturnRepository $check,
        UnitService $unit,
        SaleService $sale,
        DailyService $daily,


    ) {


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $warehouse->add();

            foreach ($this->core->data['count'] as $value) {

                // -------------------------------------------------------------------------------------

                // $result = $check->check_return($this->core->data['old'][$value]);

                // if ($result['status'] == 0) {

                //  return response(['message' => $result['text'] ,'status' => $result['status']]);

                // }
                // -------------------------------------------------------------------------------------


                $this->core->setValue($value);

                $unit->unit_and_qty(); // this make decode for unit and convert qty into miqro

                $store->store(); // this handle data in store_product table

                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table
            }

            $sale->pay();
            // dd('sdsdsdsdsdsd');

            // $daily->daily();


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



    public function receivable_bond(Request $request)
    {




        $data = DB::table('sales')
            ->where('sales.id', $request->id)
            ->join('payment_sales', 'payment_sales.sale_id', '=', 'sales.id')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('accounts', 'accounts.id', '=', 'customers.account_id')
            ->select(
                'sales.id as sale_id',
                'customers.id',
                'customers.name',
                'payment_sales.*',
                'accounts.id as account_id',
                'accounts.text'

            )
            ->get();

        return response()->json(['list_data' => $data]);
    }

    public function store_ReceivableBond(Request $request,DailyService $daily)
    {



        // dd($request->all());

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

       


            $daily->daily('date','total')
            ->depit(['account_id'])
            ->credit(['account_id', 'account_id', 'account_id'])
            ->set();
          

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "daily created successfully",
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

    function show()
    {
        $sales = DB::table('sales')
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('payment_sales', 'payment_sales.sale_id', '=', 'sales.id')
            ->select(
                // 'sales.*',
                'sales.id as sale_id',
                'customers.name',
                'payment_sales.*'
            )
            ->paginate(10);

        return response()->json(['sales' => $sales]);
    }




    function invoice_sale(Request $request, $id)
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
