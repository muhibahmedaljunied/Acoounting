<?php

namespace App\Http\Controllers\Sale;
// use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Services\UnitService;
use App\Traits\GeneralTrait;
use App\Traits\Stock\StockTrait;
use App\Services\CoreService;
use App\Services\ReturnService;
use Illuminate\Http\Request;
use App\Models\SaleReturnDetail;
use App\Http\Controllers\Controller;
use App\Services\DailyService;
use App\Models\SaleReturn;
use DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{

    use StockTrait, StoreProductTrait, GeneralTrait, ReturnDetailsTrait;


    public function __construct(
        // protected DetailRefreshRepositoryInterface $refresh,
        protected InventuryStockRepositoryInterface $stock,
        protected InventuryStoreRepositoryInterface $store,
        protected WarehouseRepositoryInterface $warehouse,
        protected ReturnRepositoryInterface $return,
        protected DetailRepositoryInterface $details,
        protected ReturnService $returnservice,
        protected CoreService $core,
        protected DailyService $daily,
        protected UnitService $unit,
        Request $request,

    ) {

        $this->core->setData($request->all());
    }

    public function index(Request $request, $id)
    {

        $details = $this->details($request->all(), $id);

        return response()->json([
            'sale_details' => $details,
            'customers' => $this->customers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function customers()
    {

        $customers = DB::table('customers')
            ->join('accounts', 'accounts.id', '=', 'customers.account_id')
            ->select(
                'customers.id',
                'customers.name',
             
            )
            ->get();

        return $customers;
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
   
            )
            ->get();

        return $treasuries;
    }

    public function show($id)
    {


        $returns = DB::table('sale_returns')->where('sale_returns.sale_id', $id)
            ->join('sales', 'sales.id', '=', 'sale_returns.sale_id')
            ->select(
                'sale_returns.*',
                'sale_returns.date as return_date',
                'sale_returns.id as return_id',
                'sale_returns.quantity as quantity_return',
                'sales.*'
            )
            ->get();


        return response()->json(['returns' => $returns]);
    }



    public function return_invoice($id)
    {


        return response()->json([
            'sale_return_details' => $this->get_sale_return($id),
            'sale_returns' => $this->get_sale_return_detail($id),
            'users' => Auth::user()
        ]);
    }



    public function get_sale_return($id)
    {


        $sale_returns = SaleReturn::where('sale_returns.id', $id)
            ->join('sales', 'sales.id', '=', 'sale_returns.sale_id')
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select(
                'sales.*',
                'sales.id as sale_id',
                'users.*',
                'sale_returns.*',
                'sale_returns.id as return_id'
            )
            ->get();
        return $sale_returns;
    }

    public function get_sale_return_detail($id)
    {


        $sale_return_details = SaleReturnDetail::where('sale_return_details.sale_return_id', $id)
            ->join('sale_returns', 'sale_returns.id', '=', 'sale_return_details.sale_return_id')
            ->join('store_products', 'store_products.id', '=', 'sale_return_details.store_product_id')
            ->joinall()
            ->select(
                'sale_return_details.*',
                'sale_return_details.quantity as qty_return',
                'sale_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'shelves.*',
                'products.text as product_name'
            )
            ->get();

        return $sale_return_details;
    }

    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        $this->core->data = $request->all();
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $this->warehouse->add();
            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->unit->unit_and_qty(); // this make decode for unit and convert qty into miqro
                $this->store->store();
                $this->returnservice->details();
                $this->stock->stock();
            }

            $this->daily->daily();
            // dd('ddddddddddd');

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            $this->daily->daily();
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
