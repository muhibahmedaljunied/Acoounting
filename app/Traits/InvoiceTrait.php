
<?php

namespace App\Traits;

use DB;
use App\Models\Supply;
use App\Models\SupplyDetail;
use App\Models\CashDetail;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use App\Models\SupplyReturnDetail;
use App\Models\CashReturnDetail;
use App\Models\ReturnSaleDetail;
use App\Models\ReturnPurchaseDetail;


trait DetailsTrait
{

    function invoice($id,$table,$tables)
    {

        $data = $table::where('supplies.id', $id) #------------------------
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as supply_id', 'suppliers.*')
            ->get();

        $details = $tables::where('supply_details.supply_id', $id)#------------------------
            // ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', 'supply_details.store_product_id')
            ->joinall()
            ->select('products.*', 'products.text as product', 'supply_details.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', 'store_products.quantity as avilable_qty', DB::raw('supply_details.qty-supply_details.qty_return AS qty_remain'))
            ->get();


        $users = Auth::user();     #------------------------


        return response()->json(['details' => $details, 'data' => $data, 'users' => $users]);

       
    }
}
