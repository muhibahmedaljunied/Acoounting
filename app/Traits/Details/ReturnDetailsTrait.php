<?php

namespace App\Traits\Details;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
trait ReturnDetailsTrait
{
 
    use UnitsTrait;

    public function return_detail(Request $request, $table)
    {

      
  
        $tables = $request->post('table');

        if ($tables == 'supply') {
           
            $table = 'supplies';
        }

        if ($tables == 'cash') {
           
            $table = 'cashes';
        }

        if ($tables == 'purchase') {
           
            $table = 'purchases';
        }

        if ($tables == 'sale') {
           
            $table = 'sales';
        }

        // dd($table);
        $return_details = DB::table($table)
        ->where($tables .'_return_details.'.$tables .'_return_id', $request->id)
            ->join($tables . '_returns', $tables . '_returns.' . $tables . '_id', '=', $table. '.id')
            ->join($tables . '_return_details', $tables . '_returns.id', '=', $tables . '_return_details.' . $tables . '_return_id')
            ->join('units', $tables . '_return_details.unit_id', '=', 'units.id')
            ->join('store_products', 'store_products.id', '=', $tables.'_return_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores','store_products.store_id', '=', 'stores.id')
            ->select(
                'store_products.*',
                $tables . '_return_details.*',
                'products.rate',
                'units.name as unit',
                $tables . '_return_details.qty as qty_return',
                $tables . '_returns.*',
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
