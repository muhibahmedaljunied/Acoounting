<?php

namespace App\Http\Controllers\Supply;

use App\Repository\StoreReturnInventury\StoreSupplyReturnRepository;
use App\Repository\StockReturnInventury\StockSupplyReturnRepository;
use Illuminate\Support\Facades\Cache;
use App\Repository\CheckData\CheckSupplyReturnRepository;
use App\Repository\Stock\SupplyReturnRepository;
use App\Traits\Details\ReturnDetailsTrait;
use App\Services\UnitService;
use App\Services\CoreService;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Models\DailyDetail;
use App\Models\SupplyDetail;
use Illuminate\Http\Request;
use App\Models\SupplyReturnDetail;
use App\Models\SupplyReturn;
use App\Services\DailyService;
use App\Services\ReturnService;
use Illuminate\Support\Facades\Auth;

use DB;

class SupplyReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait;
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
            'supply_returns' => $this->get_purshace_return_detail($id),
            'users' => Auth::user()
        ]);
    }

    public function get_purshace_return($id)
    {


        return SupplyReturn::where('supply_returns.id', $id)
            ->join('supplys', 'supplys.id', '=', 'supply_returns.supply_id')
            ->join('suppliers', 'suppliers.id', '=', 'supplys.supplier_id')
            ->select(
                'supplys.*',
                'supplys.id as supply_id',
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


        $returns = DB::table('supply_returns')->where('supply_returns.supply_id', $id)
            ->join('supplys', 'supplys.id', '=', 'supply_returns.supply_id')
            ->select(
                'supply_returns.*',
                'supply_returns.date as return_date',
                'supply_returns.quantity as qty_return',
                'supply_returns.id as return_id',
                'supplys.*'
            )
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(
        StoreSupplyReturnRepository $store,
        StockSupplyReturnRepository $stock,
        SupplyReturnRepository $warehouse,
        CheckSupplyReturnRepository $check,
        ReturnService $returnservice,
        Request $request,
        UnitService $unit,
        DailyService $daily,
    )   // this create return for supply,cashing,sale,supply
    {

        // dd($request->all());


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            $warehouse->add();

            foreach ($request->post('count') as $value) {


                // -------------------------------------------------------------------------------------

                // $result = $check->check_return($request['old'][$value]);

                // if ($result['status'] == 0) {
                //     return response(['message' => $result['text'], 'status' => $result['status']]);
                // }
                // -------------------------------------------------------------------------------------

                $this->core->setValue($value);
                $unit->unit_and_qty(); // this make decode for unit and convert qty into miqro
                $store->store();
                $returnservice->details();
                $stock->stock();
            }
            $daily->daily()->debit()->credit();
            $warehouse->refresh(); //this update supply_return table by daily_id
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

    public function supply_return_daily(Request $request)
    {



        $supplys = DB::table('supplys')
            ->where('supplys.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'supplys.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'supplys.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'supplys.*',
                'supplys.id as supply_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($supplys);
        return response()->json(['daily_details' => $supplys]);
    }

}