<?php

namespace App\Traits\Unit;

use Illuminate\Support\Facades\DB;

trait UnitsTrait
{

    public function units()
    {

       

            $this->value->units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $this->value->product_id)
                ->select('units.*', 'product_units.*')
                ->get();

                // dd($this->value->product_id);

         
    }


    

}
