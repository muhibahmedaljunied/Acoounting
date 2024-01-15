<?php

namespace App\Http\Controllers\Cash;
use App\Repository\StoreReturnInventury\StoreCashReturnRepository;
use App\Repository\StockReturnInventury\StockCashReturnRepository;
use App\Repository\CheckData\CheckCashReturnRepository;
use Illuminate\Support\Facades\Cache;
use App\Repository\Stock\CashReturnRepository;
use App\Traits\Return\ReturnTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use App\Services\CoreService;
use App\Services\ReturnService;
use Illuminate\Http\Request;
use App\Models\CashReturnDetail;
use App\Http\Controllers\Controller;
use App\Models\DailyDetail;
use App\Models\CashDetail;
use App\Services\DailyService;
use App\Models\CashReturn;
use DB;
use Illuminate\Support\Facades\Auth;

class CashReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait,
        ReturnTrait;


    public function __construct(

        protected CoreService $core,
        Request $request,

    ) {

        $this->core->setData($request->all());
    }

    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        $this->units($details);

        return response()->json([
            'details' => $details,
            // 'customers' => $this->customers(),
            'treasuries' => $this->treasuries()
        ]);
    }


    public function index(Request $request, $id)
    {

        $details = $this->details($request, $id);

        return response()->json([
            'cash_details' => $details,
            'customers' => $this->customers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function customers()
    {

        return DB::table('customers')
            ->join('accounts', 'accounts.id', '=', 'customers.account_id')
            ->select(
                'customers.id',
                'customers.name',
                'customers.account_id',


            )
            ->get();
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                'treasuries.account_id',

            )
            ->get();
    }

    public function show($id)
    {


        $returns = DB::table('cash_returns')->where('cash_returns.cash_id', $id)
            ->join('cashs', 'cashs.id', '=', 'cash_returns.cash_id')
            ->select(
                'cash_returns.*',
                'cash_returns.date as return_date',
                'cash_returns.id as return_id',
                'cash_returns.quantity as quantity_return',
                'cashs.*'
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
            ->join('cashs', 'cashs.id', '=', 'cash_returns.cash_id')
            ->join('users', 'users.id', '=', 'cashs.customer_id')
            ->select(
                'cashs.*',
                'cashs.id as cash_id',
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
        StoreCashReturnRepository $store,
        StockCashReturnRepository $stock,
        CashReturnRepository $warehouse,
        ReturnService $returnservice,
        CheckCashReturnRepository $check,
        UnitService $unit,
        DailyService $daily,
    
    )   // this create return for supply,cashing,cash,purchase
    {

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

                $store->store();
        
                $returnservice->details();

                $stock->stock();
                
            }
            $daily->daily()->debit()->credit();

            $warehouse->refresh();//this update cash_return table by daily_id
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

    public function cash_return_aily(Request $request){

        
       
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
}
