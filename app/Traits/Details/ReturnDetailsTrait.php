<?php

namespace App\Traits\Details;

use DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

trait ReturnDetailsTrait
{

   
    public function return_detail(Request $request,$table)
    {
       $table = $request->post('table');
        $return_details = DB::table($table.'s')->where($table.'_return_details.'.$table.'_return_id', $request->id)
            ->join($table.'_returns', $table.'_returns.'.$table.'_id', '=', $table.'s.id')
            ->join($table.'_return_details', $table.'_returns.id', '=', $table.'_return_details.'.$table.'_return_id')
            ->join('products', $table.'_return_details.product_id', '=', 'products.id')
            ->join('statuses', $table.'_return_details.status_id', '=', 'statuses.id')
            ->join('stores', $table.'_return_details.store_id', '=', 'stores.id')
            ->join('units',$table.'_return_details.unit_id', '=', 'units.id')
            ->select($table.'_return_details.*','products.rate','units.name as unit', $table.'_return_details.qty as qty_return', $table.'_returns.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'products.text as product_name')
            ->get();

            $this->units($return_details);
       


        return response()->json(['return_details' => $return_details]);


        
    }
}
