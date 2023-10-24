<?php

namespace App\Http\Controllers\Warehouse;


use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\CashReturn;
use App\Models\CashReturnDetail;
use Illuminate\Support\Facades\Auth;
use App\Facades\Returns;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\Services\ReturnService;
use DB;

class CashReturnController extends Controller
{


    use StockTrait;
    use StoreProductTrait;


    public function __construct(
        protected ReturnRepositoryInterface $return,
        protected ReturnService $service
    ) {
        $this->return = $return;
        $this->service = $service;
    }
    public function show($id)
    {
        $return_cashes = DB::table('cash_returns')->where('cash_returns.cash_id', $id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->select(
                'cash_returns.*',
                'cash_returns.date as return_date',
                'cash_returns.id as return_id',
                'cash_returns.quantity as quantity_return',
                'cashes.*'
            )
            ->get();

        return response()->json(['return_cashes' => $return_cashes]);
    }

    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {


        $request_data = $request->post('old');

        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

        foreach ($request_data as $value) {

            $result = $this->return->check_return($value);

            if ($result['message'] == 0) {

                return response()->json(['message' => 0, 'text' => $result['text']]);
            }
        }
        // -------------------------------------------------------------------------------------------------

        // $return_id = Returns::store_return($request->all());
        $return_id = $this->return->store_return($request->all());

        // -------------------------------------------------------------------------------------------------

        foreach ($request->post('count') as $value) {
            $data = array_merge($request->all(), $value);

            $this->service->create($data, $return_id);
        }
        // return response()->json(['message' => $data]);
        return response()->json(['message' => 'success']);
    }

    public function return_invoice($id)
    {


        $cash_returns = CashReturn::where('cash_returns.id', $id)
            ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->select(
                'cashes.*',
                'cashes.id as cash_id',
                'customers.*',
                'cash_returns.*',
                'cash_returns.id as return_id'
            )
            ->get();



        $cash_return_details = CashReturnDetail::where('cash_return_details.cash_return_id', $id)
            ->join('cash_returns', 'cash_returns.id', '=', 'cash_return_details.cash_return_id')
            // ->join('cashes', 'cashes.id', '=', 'cash_returns.cash_id')
            // ->join('cash_details', 'cashes.id', '=', 'cash_details.cash_id')
            ->join('store_products', 'store_products.id', '=', 'cash_return_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')

            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select(
                'cash_return_details.*',
                'cash_return_details.quantity as qty_return',
                'cash_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'stores.text as store',
                'products.text as product'
            )
            ->get();

        $users = Auth::user();

        return response()->json(['cash_return_details' => $cash_return_details, 'cash_returns' => $cash_returns, 'users' => $users]);
    }
}
