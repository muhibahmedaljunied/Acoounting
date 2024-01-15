<?php

namespace App\Http\Controllers\Sale;
use App\Repository\Note\ReceivableBondRepository;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Services\SalePaymentService;
use App\Traits\Unit\UnitsTrait;
class ReceivableBondController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        GeneralTrait;


    public function __construct(
        Request $request,
        public SalePaymentService $payment,
        protected CoreService $core,

    ) {

        $this->core->setData($request->all());

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
                'customers.account_id as customer_account_id',
                'customers.name',
                'payment_sales.*',
                'accounts.id as account_id',
                'accounts.text'

            )
            ->get();

        return response()->json(['list_data' => $data]);
    }

    public function store_ReceivableBond(
        DailyService $dailyService,
        ReceivableBondRepository $note
    ) {




        // dd($this->core->data);

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $dailyService->daily()->debit()->credit();
            $note->finish();
            $this->payment->update_receivableBond();



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


    public function ReceivableBondlist()
    {


        $payable = DB::table('payable_notes')
            ->join('purchases', 'purchases.id', '=', 'payable_notes.purchase_id')
            ->join('dailies', 'dailies.id', '=', 'payable_notes.daily_id')
            // ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select(
                'purchases.supplier_name',
                'purchases.id as purchase_id',
                'payable_notes.*',
                'dailies.total',
            )
            ->paginate(10);

        return response()->json(['payable' => $payable]);
    }

   
}
