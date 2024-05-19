<?php

namespace App\Traits\Unit;
use Illuminate\Support\Facades\DB;
trait UnitsTrait
{

    public function units($details)
    {

        foreach ($details as $value) {

            $units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $value->product_id)
                ->select('units.*', 'products.rate', 'product_units.unit_type')
                ->get();

        

            $value->units = $units;
        }
    }

    
}
