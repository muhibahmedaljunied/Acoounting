<?php

namespace App\Http\Controllers\Purchase;


use Illuminate\Support\Facades\Cache;
use App\Repository\CheckData\CheckPurchaseReturnRepository;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturn;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait;
    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        $this->units($details);


        $purchase =  DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'suppliers.id',
                'suppliers.name',
                // 'suppliers.account_id',
                'purchases.grand_total',


            )
            ->get();

        return response()->json([
            'details' => $details,
            'purchase' => $purchase,

        ]);
    }

    public function index(Request $request, $id)
    {



        $details = $this->details($request, $id);


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
                'suppliers.account_id',

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
                'treasuries.account_id',

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
    public function create(
        StockService $stock,
    )   // this create return for supply,cashing,sale,purchase
    {




        // dd( $stock->core->data);
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $stock->handle();


            Cache::forget('stock');

            // dd(1);

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "PurchaseReturn created successfully",
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

    public function return_purchase_daily(Request $request)
    {



        $purchase_returns = DB::table('purchase_returns')
            ->where('purchase_returns.id', $request->id)
            // ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'purchase_returns.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'purchases.*',
                'purchase_returns.id as purchase_return_id',
                // 'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($purchases);
        return response()->json(['daily_details' => $purchase_returns]);
    }
}
