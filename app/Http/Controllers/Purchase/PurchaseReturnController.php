<?php

namespace App\Http\Controllers\Purchase;

use App\Traits\Details\ReturnDetailsTrait;
use App\Services\CoreService;
use App\Traits\GeneralTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\StockRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturn;
use App\Services\DailyService;
use App\Services\ReturnService;
use Illuminate\Support\Facades\Auth;
use DB;

class PurchaseReturnController extends Controller
{

    use StockTrait,
        StoreProductTrait,
        GeneralTrait,
        ReturnDetailsTrait;

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

    public function return_invoice($id)
    {

        $purchase_returns = PurchaseReturn::where('purchase_returns.id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.*', 'purchase_returns.*', 'purchase_returns.id as return_id')
            ->get();



        $return_details = PurchaseReturnDetail::where('purchase_return_details.purchase_return_id', $id)
            ->join('purchase_returns', 'purchase_returns.id', '=', 'purchase_return_details.purchase_return_id')
            ->join('store_products', 'store_products.id', '=', 'purchase_return_details.store_product_id')
            ->joinall()
            ->select('purchase_return_details.*', 'purchase_return_details.qty as qty_return', 'purchase_returns.*', 'statuses.*', 'shelves.*', 'statuses.name as status', 'stores.*', 'products.text as product_name')
            ->get();

        $users = Auth::user();

        return response()->json(['return_details' => $return_details, 'purchase_returns' => $purchase_returns, 'users' => $users]);
    }

    public function index(Request $request)
    {


        $suppliers = DB::table('suppliers')
            ->join('supplier_accounts', 'supplier_accounts.supplier_id', '=', 'suppliers.id')
            ->select('suppliers.id', 'suppliers.name', 'supplier_accounts.account_id')
            ->get();

        $treasuries = DB::table('treasuries')
            ->join('treasury_accounts', 'treasury_accounts.treasury_id', '=', 'treasuries.id')
            ->select('treasuries.id', 'treasuries.name', 'treasury_accounts.account_id')
            ->get();
        $details = $this->details($request->all(), $request->id);

        return response()->json(['purchase_details' => $details, 'suppliers' => $suppliers, 'treasuries' => $treasuries]);
    }

    public function show($id)
    {


        $returns = DB::table('purchase_returns')->where('purchase_returns.purchase_id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->select('purchase_returns.*', 'purchase_returns.date as return_date', 'purchase_returns.quantity as qty_return', 'purchase_returns.id as return_id', 'purchases.*')
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        $this->core->data = $request->all();
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

        
            $this->stock->add();
          

            foreach ($request->post('count') as $value) {

                $this->core->value  = $value;
                $this->stock->decode_unit()->convert_qty(); // this make decode for unit and convert qty into miqro
                $this->returnservice->store()->details()->stock();
            }

            // dd('ddddddddddd');

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            $this->returnservice->daily();
            return response([
                'message' => "purchaseReturn created successfully",
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



