<?php

namespace App\Http\Controllers\Sale;

use App\Services\StockService;
use Illuminate\Support\Facades\Cache;
use App\Traits\Return\ReturnTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\SaleReturnDetail;
use App\Http\Controllers\Controller;
use App\Models\SaleReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{

    use GeneralTrait,
        ReturnDetailsTrait,
        ReturnTrait;




    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        $this->units($details);

        
        $sale =  DB::table('sales')
            ->where('sales.id', $request->id)
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->select(
                'customers.id',
                'customers.name',
                'sales.grand_total',


            )
            ->get();

        return response()->json([
            'details' => $details,
            'sale' => $sale,

            // 'customers' => $this->customers(),
            // 'treasuries' => $this->treasuries()
        ]);
    }


    public function index(Request $request, $id)
    {

        $details = $this->details($request, $id);

        return response()->json([
            'sale_details' => $details,
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

    public function return_sale_daily(Request $request)
    {



        $sale_returns = DB::table('sale_returns')->where('sale_returns.id', $request->id)
            // ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('dailies', 'dailies.id', '=', 'sale_returns.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'sales.*',
                'sale_returns.id as sale_return_id',
                // 'customers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($sales);
        return response()->json(['daily_details' => $sale_returns]);
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


        return SaleReturn::where('sale_returns.id', $id)
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
    }

    public function get_sale_return_detail($id)
    {


        return SaleReturnDetail::where('sale_return_details.sale_return_id', $id)
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
    }

    public function create(
        StockService $stock,
    )   // this create return for supply,cashing,sale,purchase
    {

      
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            $stock->handle();

            // dd(1);
            Cache::forget('stock');

      


            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

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

    public function sale_return_aily(Request $request)
    {



        $sales = DB::table('sales')->where('sales.id', $request->id)
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('dailies', 'dailies.id', '=', 'sales.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'sales.*',
                'sales.id as sale_id',
                'customers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($sales);
        return response()->json(['daily_details' => $sales]);
    }
}
