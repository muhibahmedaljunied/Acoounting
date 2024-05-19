<?php

namespace App\Traits\Return;
use Illuminate\Support\Facades\DB;
trait ReturnTrait
{
    
    public function check_return($value)
    {

        $qty_return_now = $value['qty_return_now'];
        $qty_remain = $value['qty_remain'];
        $qty = $value['qty'];


        foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

            //[0] =id,[1] = rate,[2] = unit_type
            if ($value['unit_selected'][2] == 1) {


                $qty_return_now = $value['qty_return_now'] * $value['rate'];
                $qty_remain = $value['qty_remain'] * $value['rate'];
                $qty = $value['qty'] * $value['rate'];
            }
        }

        // -------------------------------------------------------------------------------------------------------------------



        if ($qty_return_now > $value['avilable_qty']) {

            return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"]);
        }

        if ($qty_return_now > $qty_remain) {

            return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"]);
        }

        if ($qty_return_now > $qty) {

            return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المباعه"]);
        }

        if ($qty_remain == 0) {

            return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
        }
    }
    


    function check_detail($type)
    {
        // $detail = 0;

        $detail = DB::table('purchase_return_details')
            ->select('purchase_return_details.*')
            ->get();




        return $detail;
    }
}
