<?php

namespace App\Http\Controllers\Sale;
use App\Repository\CheckData\CheckSaleReturnRepository;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StockInventury\StockSaleRepository;
use Illuminate\Support\Facades\Cache;
use App\Repository\Stock\SaleRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Services\PaymentService;
use App\Traits\Unit\UnitsTrait;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SaleController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        GeneralTrait;


    public function __construct(
        Request $request,
        public PaymentService $payment,
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
        DailyService $daily,


    ) {


        // dd($this->core->data);
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

            $this->payment->pay();
            $daily->daily()->debit()->credit();
            $warehouse->refresh(); //this update sale table by daily_id
            Cache::forget('stock');

            // dd(1);

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



    public function sale_daily(Request $request){

        
       
        $sales = DB::table('sales')->where('sales.id',$request->id)
        ->join('customers', 'customers.id', '=', 'sales.customer_id')
        ->join('dailies', 'dailies.id', '=', 'sales.daily_id')
        ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
        ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
        ->select(
            // 'sales.*',
            'sales.id as sale_id',
            'customers.name',
            'dailies.*',
            'daily_details.*',
            'accounts.text',
            'accounts.id as account_id',

          
        )
        ->get();

        // dd($sales);
    return response()->json(['daily_details' => $sales]);

    }

    public function show()
    {

    
        $sales = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Sale::class => function ($query) {

                    $query->join('customers', 'customers.id', '=', 'sales.customer_id');
                    $query->select('sales.*','sales.id as sale_id','customers.name as customer_name');
                },
            ]);
        }])
        ->where('paymentable_type','App\\Models\\Sale')
        ->paginate();

       
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
