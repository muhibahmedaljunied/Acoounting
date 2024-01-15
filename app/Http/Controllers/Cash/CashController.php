<?php

namespace App\Http\Controllers\Cash;
use App\Repository\CheckData\CheckCashReturnRepository;
use App\Repository\StoreInventury\StoreCashRepository;
use App\Repository\StockInventury\StockCashRepository;
use Illuminate\Support\Facades\Cache;
use App\Repository\Stock\CashRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Services\CashPaymentService;
use App\Traits\Unit\UnitsTrait;
use App\Models\Cash;
use App\Models\CashDetail;

class CashController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        GeneralTrait;


    public function __construct(
        Request $request,
        public CashPaymentService $payment,
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
        StoreCashRepository $store,
        StockCashRepository $stock,
        CashRepository $warehouse,
        CheckCashReturnRepository $check,
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
            $warehouse->refresh(); //this update cash table by daily_id
            Cache::forget('stock');

            // dd(CashDetail::all());

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



    public function cash_daily(Request $request){

        
       
        $cashs = DB::table('cashs')->where('cashs.id',$request->id)
        ->join('customers', 'customers.id', '=', 'cashs.customer_id')
        ->join('dailies', 'dailies.id', '=', 'cashs.daily_id')
        ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
        ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
        ->select(
            // 'cashs.*',
            'cashs.id as cash_id',
            'customers.name',
            'dailies.*',
            'daily_details.*',
            'accounts.text',
            'accounts.id as account_id',

          
        )
        ->get();

        // dd($cashs);
    return response()->json(['daily_details' => $cashs]);

    }

    function show()
    {
        $cashs = DB::table('cashs')
            ->join('customers', 'customers.id', '=', 'cashs.customer_id')
            ->join('payment_cashs', 'payment_cashs.cash_id', '=', 'cashs.id')
            ->select(
                'cashs.*',
                'cashs.id as cash_id',
                'customers.name',
                'payment_cashs.*',
                'payment_cashs.payment_status'
            )
            ->paginate(10);

        return response()->json(['cashs' => $cashs]);
    }




    function invoice_cash(Request $request, $id)
    {

        $table = $request->post('table');

        $cashs = Cash::where('cashs.id', $id)
            ->join('users', 'users.id', '=', 'cashs.customer_id')
            ->select('cashs.*', 'cashs.id as cash_id', 'users.*')
            ->get();
        $details = $this->invoice($id, $table);

        $users = Auth::user();
        return response()->json([$table => $details, 'cashs' => $cashs, 'users' => $users]);
    }
}
