<?php

namespace App\Traits\Return;

use App\Models\SupplyReturn;
use App\Models\CashReturn;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use DB;

trait ReturnTrait
{
    // public function create_return($data, $return_id)   // this create return for supply,cashing,sale,purchase
    // {

    //     $stock_f = 0;
    //     $this->refresh_store(
    //         data: $data
    //     ); // this make updating for store_products
    //     // -------------------------------------------------------------------------------------------------

    //     $id_store_product = $this->get($data);  //this get data from store_products


    //     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //     foreach ($id_store_product as $values) {


    //         $id_store_product = $values['id'];
    //     }

    //     //----------------------------------------------------------------------------------------------------------------------------------------- 
    //     $this->init_details(
    //         id: $return_id,
    //         id_store_product: $id_store_product,
    //         data: $data
    //     ); // this make initial for details tables
    //     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //     $stock_f = $this->refresh_stock(
    //         id: $return_id,
    //         data: $data
    //     ); // this make update for stock table
    //     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //     $this->refresh_details( 
    //         data:$data, 
    //     );
    //     //----------------------------------------------------------------------------------------------------------------------------------------- 

    //     if ($stock_f == 0) {

    
    //         $this->init_stock(
    //             data: $data
    //         ); //this make intial for stock table if it is empty 
    //     }
    // }

    // function store_return($request)
    // {

    //     $tables = '';
    //     switch ($request['type']) {


    //         case 'SupplyReturn':
    //             $return = new SupplyReturn();
    //             $return->supply_id = $request['id']; #this equal supply_id
    //             $tables = 'supplies';

    //             break;

    //         case 'CashReturn':

    //             $return = new CashReturn();
    //             $return->cash_id = $request['id']; #this equal cash_id
    //             $tables = 'cashes';
    //             break;
    //         case 'PurchaseReturn':

    //             $return = new PurchaseReturn();
    //             $return->purchase_id = $request['id'];
    //             $tables = 'purchases';
    //             break;

    //         case 'SaleReturn':

    //             $return = new SaleReturn();
    //             $return->sale_id = $request['id'];
    //             $tables = 'sales';

    //             break;

    //         default:
    //             break;
    //     }

    //     $return->date  = $request['date'];
    //     // $return->quantity = $request->post('total');
    //     $return->note  = $request['note'];
    //     $return->save();

    //     return $return->id;
    // }


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
