<?php

namespace App\Http\Controllers\Supply;
use Illuminate\Support\Facades\Cache;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\SupplyReturnDetail;
use App\Models\SupplyReturn;
use App\Services\StockReturnService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class SupplyReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait;
 


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

    public function index(Request $request, $id)
    {



        $details = $this->details($request, $id);


        return response()->json([
            'supply_details' => $details,
            'suppliers' => $this->suppliers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function suppliers()
    {

        return DB::table('suppliers')
            ->select(
                'suppliers.*',


            )
            ->get();
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            ->select(
                'treasuries.*',


            )
            ->get();

        return $treasuries;
    }


    public function return_invoice($id)
    {


        return response()->json([
            'return_details' => $this->get_purshace_return($id),
            'supply_returns' => $this->get_purshace_return_detail($id),
            'users' => Auth::user()
        ]);
    }

    public function get_purshace_return($id)
    {


        return SupplyReturn::where('supply_returns.id', $id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select(
                'supplies.*',
                'supplies.id as supply_id',
                'suppliers.*',
                'supply_returns.*',
                'supply_returns.id as return_id'
            )
            ->get();
    }

    public function get_purshace_return_detail($id)
    {


        return SupplyReturnDetail::where('supply_return_details.supply_return_id', $id)
            ->join('supply_returns', 'supply_returns.id', '=', 'supply_return_details.supply_return_id')
            ->join('store_products', 'store_products.id', '=', 'supply_return_details.store_product_id')
            ->joinall()
            ->select(
                'supply_return_details.*',
                'supply_return_details.qty as qty_return',
                'supply_returns.*',
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


        // $returns = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
        //     $morphTo->constrain([
        //         SupplyReturn::class => function ($query) {
        //             // $query->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id');
        //             $query->select('supplies.*', 'supplies.id as supply_id');
        //         },
        //     ]);
        // }])
        //     ->where('paymentable_type', 'App\\Models\\SupplyReturn')
        //     ->paginate(10);


        // return response()->json(['returns' => $returns]);

        // -----------------------------------------------------------------------------------------------
        $returns = DB::table('supply_returns')->where('supply_returns.supply_id', $id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->select(
                'supply_returns.*',
                'supply_returns.date as return_date',
                'supply_returns.quantity as qty_return',
                'supply_returns.id as return_id',
                'supplies.*'
            )
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(

        StockReturnService $stock
    )   // this create return for supply,cashing,sale,supply
    {

        // dd($request->all());


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $stock->handle();
            Cache::forget('stock');

            // dd(DailyDetail::all());

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "supplyReturn created successfully",
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

    public function return_supply_daily(Request $request)
    {



        $supplies = DB::table('supplies')
            ->where('supplies.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'supplies.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'supplies.*',
                'supplies.id as supply_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($supplies);
        return response()->json(['daily_details' => $supplies]);
    }
}
