<?php

namespace App\Http\Controllers\Purchase;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Details\ReturnDetailsTrait;
use App\Services\UnitService;
use App\Services\CoreService;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturn;
use App\Services\DailyService;
use App\Services\ReturnService;
use Illuminate\Support\Facades\Auth;

use DB;

class PurchaseReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait;
    public function __construct(
        protected ReturnService $returnservice,
        protected ReturnRepositoryInterface $return,
        protected DetailRepositoryInterface $details,
        protected WarehouseRepositoryInterface $warehouse,
        protected InventuryStockRepositoryInterface $stock,
        protected InventuryStoreRepositoryInterface $store,
        protected UnitService $unit,
        protected CoreService $core,
        protected DailyService $daily,
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
            // 'suppliers' => $this->suppliers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function index(Request $request,$id)
    {



        $details = $this->details($request,$id);


        return response()->json([
            'purchase_details' => $details,
            'suppliers' => $this->suppliers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function suppliers()
    {

        return DB::table('suppliers')
            ->join('accounts', 'accounts.id', '=', 'suppliers.account_id')
            ->select(
                'suppliers.id',
                'suppliers.name',
          
            )
            ->get();

  
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


    public function return_invoice($id)
    {


        return response()->json([
            'return_details' => $this->get_purshace_return($id),
            'purchase_returns' => $this->get_purshace_return_detail($id),
            'users' => Auth::user()
        ]);
    }

    public function get_purshace_return($id)
    {


        return PurchaseReturn::where('purchase_returns.id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'purchases.*',
                'purchases.id as purchase_id',
                'suppliers.*',
                'purchase_returns.*',
                'purchase_returns.id as return_id'
            )
            ->get();

    }

    public function get_purshace_return_detail($id)
    {


        return PurchaseReturnDetail::where('purchase_return_details.purchase_return_id', $id)
            ->join('purchase_returns', 'purchase_returns.id', '=', 'purchase_return_details.purchase_return_id')
            ->join('store_products', 'store_products.id', '=', 'purchase_return_details.store_product_id')
            ->joinall()
            ->select(
                'purchase_return_details.*',
                'purchase_return_details.qty as qty_return',
                'purchase_returns.*',
                'statuses.*',
                'shelves.*',
                'statuses.name as status',
                'stores.*',
                'products.text as product_name'
            )
            ->get();


    }

    public function show($id)
    {


        $returns = DB::table('purchase_returns')->where('purchase_returns.purchase_id', $id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->select(
                'purchase_returns.*',
                'purchase_returns.date as return_date',
                'purchase_returns.quantity as qty_return',
                'purchase_returns.id as return_id',
                'purchases.*'
            )
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        // $this->core->data = $request->all();


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

            dd('sdsd');
            $this->daily->daily();
            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            $this->daily->daily();
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
