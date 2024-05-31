<?php

namespace App\Traits\Unit;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;
use stdClass;

trait UnitsTrait
{

    public function units()
    {

        // foreach ($details as $key => $value) {

            // $this->r[$value->unit][$key] = [];



            $this->units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $this->value->product_id)
                ->select('units.*', 'product_units.*')
                ->get();

            // $this->quantity = $value->qty;

            // $this->convert_qty($units,$value,$key);
            //    $this->r = new stdClass();
        // }
        // dd($details);
    }


    // public function convert_qty($units,$value,$key){


        
    //     foreach ($units as $key2 => $value2) {



    //         if ($this->quantity / $value2->rate >= 1) {


    //             $this->r["$key"]["$key2"] = array(

    //                 // "$key2" => array(
    //                     [intval($this->quantity / $value2->rate), $value2->name]
    //                 // )
    //             );
               
    //         }

    //         if ($this->quantity % $value2->rate >= 1) {

    //             $this->quantity = $this->quantity % $value2->rate;
    //         } else {

    //             break;
    //         }

    //         // $this->divid_one($value2, $key);




    //     }

    //     $value->qty_after_convert = $this->r;
    //     // dd($this->r);
    //        $this->r = array(
    //         array(

    //         )
    //        );

    // }

}
