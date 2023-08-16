<?php

namespace App\Http\Controllers\Sale;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\GeneralTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\Stock\StockTrait;
use App\Services\CoreService;
use App\Services\ReturnService;
use App\Traits\StoreProduct\StoreProductTrait;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\StockRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\SaleReturnDetail;
use App\Http\Controllers\Controller;
use App\Services\DailyService;
use App\Models\SaleReturn;
use App\Facades\Returns;
use DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{

    use TemporaleTrait, StockTrait, StoreProductTrait,GeneralTrait,ReturnDetailsTrait;


    public function __construct(
        protected ReturnService $returnservice,
        protected ReturnRepositoryInterface $return,
        protected DetailRepositoryInterface $details,
        protected DetailRefreshRepositoryInterface $refresh,
        protected StockRepositoryInterface $stock,
        protected CoreService $core,
        protected DailyService $daily,
    ) {
    }

    public function index(Request $request, $id)
    {
   

        $customers = DB::table('customers')
            ->join('customer_accounts', 'customer_accounts.customer_id', '=', 'customers.id')
            ->select('customers.id', 'customers.name', 'customer_accounts.account_id')
            ->get();

        $treasuries = DB::table('treasuries')
            ->join('treasury_accounts', 'treasury_accounts.treasury_id', '=', 'treasuries.id')
            ->select('treasuries.id', 'treasuries.name', 'treasury_accounts.account_id')
            ->get();

      
        $details = $this->details($request->all(), $id);

        return response()->json(['sale_details' => $details, 'customers' => $customers, 'treasuries' => $treasuries]);
    }
    public function show($id)
    {


        $returns = DB::table('sale_returns')->where('sale_returns.sale_id', $id)
            ->join('sales', 'sales.id', '=', 'sale_returns.sale_id')
            ->select('sale_returns.*', 'sale_returns.date as return_date', 'sale_returns.id as return_id', 'sale_returns.quantity as quantity_return', 'sales.*')
            ->get();


        return response()->json(['returns' => $returns]);
    }



    public function return_invoice($id)
    {


        $sale_returns = SaleReturn::where('sale_returns.id', $id)
            ->join('sales', 'sales.id', '=', 'sale_returns.sale_id')
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'users.*', 'sale_returns.*', 'sale_returns.id as return_id')
            ->get();



        $sale_return_details = SaleReturnDetail::where('sale_return_details.sale_return_id', $id)
            ->join('sale_returns', 'sale_returns.id', '=', 'sale_return_details.sale_return_id')
            ->join('store_products', 'store_products.id', '=', 'sale_return_details.store_product_id')
            ->joinall()
            ->select('sale_return_details.*', 'sale_return_details.quantity as qty_return', 'sale_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'shelves.*', 'products.text as product_name')
            ->get();

        $users = Auth::user();

        return response()->json(['sale_return_details' => $sale_return_details, 'sale_returns' => $sale_returns, 'users' => $users]);
    }


    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        $this->core->data = $request->all();
        // dd($request->all());
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $this->stock->add();
            foreach ($request->post('count') as $value) {

                $this->core->value  = $value;
                $this->stock->decode_unit()->convert_qty(); // this make decode for unit and convert qty into miqro
                // dd($this->core->micro_unit_qty);
                $this->returnservice->store()->details()->stock();
            }

            // dd('ddddddddddd');

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            $this->returnservice->daily();
            return response([
                'message' => "SaleReturn created successfully",
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
}

