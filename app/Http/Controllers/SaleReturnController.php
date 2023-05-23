<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\GeneralTrait;
use App\Traits\Details\ReturnDetailsTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use Illuminate\Http\Request;
use App\Models\SaleReturnDetail;
use App\Models\SaleReturn;
use App\Facades\Returns;
use DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{

    use TemporaleTrait, StockTrait, StoreProductTrait, GeneralTrait, ReturnDetailsTrait;


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



        $request_data = $request->post('old');

        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------
        foreach ($request_data as $value) {

            $result = Returns::check_return($value);

            if ($result['message'] == 0) {

                return response()->json(['message' => 0, 'text' => $result['text']]);
            }
        }
        // -------------------------------------------------------------------------------------------------
        $return_id = Returns::store_return($request->all());
        // -------------------------------------------------------------------------------------------------
        foreach ($request_data as $value) {

            $data = array_merge($request->all(), $value);
            $data['qty'] = $result['qty'];
            Returns::create($data, $return_id);
        }
        // return response()->json(['message' => $data]);
        return response()->json(['message' => 'success']);
    }
}
