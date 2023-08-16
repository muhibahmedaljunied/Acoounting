<?php

namespace App\Traits\Details;

use DB;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

trait ReturnDetailsTrait
{
 
    use UnitsTrait;

    public function return_detail(Request $request, $table)
    {
        $table = $request->post('table');
        $return_details = DB::table($table .'s')->where($table .'_return_details.'.$table .'_return_id', $request->id)
            ->join($table . '_returns', $table . '_returns.' . $table . '_id', '=', $table . 's.id')
            ->join($table . '_return_details', $table . '_returns.id', '=', $table . '_return_details.' . $table . '_return_id')
            ->join('units', $table . '_return_details.unit_id', '=', 'units.id')
            ->join('store_products', 'store_products.id', '=', $table.'_return_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores','store_products.store_id', '=', 'stores.id')
            ->select(
                'store_products.*',
                $table . '_return_details.*',
                'products.rate',
                'units.name as unit',
                $table . '_return_details.qty as qty_return',
                $table . '_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'products.text as product_name'
            )
            ->get();

            // dd($return_details);
        $this->units($return_details);



        return response()->json(['return_details' => $return_details]);
    }
}
