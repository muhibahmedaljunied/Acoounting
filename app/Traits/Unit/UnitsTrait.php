<?php

namespace App\Traits\Unit;

use DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

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

    //   public function unit ($request,$value){

        
    //     foreach ($request['old'] as $key => $values) {   //this for converts qty_avaliable into big unit

    //         $micro_unit_qty = $request['qty'][$value];

    //         if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 1){

                    
    //              $micro_unit_qty = $request['qty'][$value]*$request['unit_id'][$value][1]; 
    
    //         }

    //         if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 0){

                    
    //               $micro_unit_qty = $request['qty'][$value];
    
    //         }

    //     }

    //     return $micro_unit_qty;



    // }
}
