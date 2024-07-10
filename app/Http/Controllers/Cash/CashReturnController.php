<?php

namespace App\Http\Controllers\Cash;

use Illuminate\Support\Facades\Cache;
use App\Traits\Return\ReturnTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\CashReturnDetail;
use App\Http\Controllers\Controller;
use App\Models\CashReturn;
use App\Models\Payment;
use App\Repository\Qty\QtyStockRepository;
use App\Services\StockReturnService;
use App\Services\StockService;
use App\Services\UnitService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashReturnController extends Controller
{

    use GeneralTrait,
        ReturnTrait;
    public $details;


    public function  __construct(public QtyStockRepository $qty)
    {
        $this->qty = $qty;
    }

    // public function details(Request $request, $id)
    // {

    //     $this->get_details($request, $id);
    //     $this->unit->handle_unit($this->details);

    //     // $this->units($details);

    //     return response()->json([
    //         'details' => $this->details,
    //         'treasuries' => $this->treasuries()
    //     ]);
    // }

    public function details(Request $request, $id)
    {

        $this->qty->compare_array = ['qty','quantity','qty_remain'];
        $this->get_details($request, $id);
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,
            // 'cash' => $this->get_sale($request->id),
        ]);
    }



    public function index(Request $request, $id)
    {

        $this->details($request, $id);

        return response()->json([
            'cash_details' => $this->details,
            'customers' => $this->customers(),
            // 'treasuries' => $this->treasuries()
        ]);
    }

    public function customers()
    {

        return DB::table('customers')
            // ->join('accounts', 'accounts.id', '=', 'customers.account_id')
            ->select(
                'customers.*',
                // 'customers.name',
                // 'customers.account_id',


            )
            ->get();
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            // ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.*',
                // 'treasuries.name',
                // 'treasuries.account_id',

            )
            ->get();
    }

    public function show($id)
    {


        $returns = DB::table('cash_returns')->where('cash_returns.cash_id', $id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->select(
                'cash_returns.*',
                'cash_returns.date as return_date',
                'cash_returns.id as return_id',
                'cash_returns.quantity as quantity_return',
                'cashes.*'
            )
            ->get();


        return response()->json(['returns' => $returns]);
    }



    public function return_invoice($id)
    {


        return response()->json([
            'cash_return_details' => $this->get_cash_return($id),
            'cash_returns' => $this->get_cash_return_detail($id),
            'users' => Auth::user()
        ]);
    }



    public function get_cash_return($id)
    {


        return CashReturn::where('cash_returns.id', $id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->join('users', 'users.id', '=', 'cashes.customer_id')
            ->select(
                'cashes.*',
                'cashes.id as cash_id',
                'users.*',
                'cash_returns.*',
                'cash_returns.id as return_id'
            )
            ->get();
    }

    public function get_cash_return_detail($id)
    {


        return CashReturnDetail::where('cash_return_details.cash_return_id', $id)
            ->join('cash_returns', 'cash_returns.id', '=', 'cash_return_details.cash_return_id')
            ->join('store_products', 'store_products.id', '=', 'cash_return_details.store_product_id')
            ->joinall()
            ->select(
                'cash_return_details.*',
                'cash_return_details.quantity as qty_return',
                'cash_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'shelves.*',
                'products.text as product_name'
            )
            ->get();
    }

    public function create(
        StockService $stock,
        

    )   // this create return for supply,cashing,cash,purchase
    {

        // dd($stock->core->data);
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $stock->handle();
            Cache::forget('stock');

            // dd(DailyDetail::all());


            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "CashReturn created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        // return response()->json(['message' => $responce]);

    }

    public function return_cash_daily(Request $request)
    {



        $cash_returns = DB::table('cash_returns')->where('cash_returns.id', $request->id)
            // ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->join('dailies', 'dailies.id', '=', 'cash_returns.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'cashes.*',
                'cash_returns.id as cash_id',
                // 'customers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($cashes);
        return response()->json(['daily_details' => $cash_returns]);
    }

    public function return_cash_list()
    {


        $cashes = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                CashReturn::class => function ($query) {
                    // $query->join('customers', 'customers.id', '=', 'cashes.customer_id');

                    $query->select(
                        'cashe_returns.*',
                        'cashe_returns.id as return_id',

                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\CashReturn')
            ->paginate(5);


        return response()->json(['cashes' => $cashes]);
    }

}
