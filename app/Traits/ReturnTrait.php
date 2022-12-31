<?php

namespace App\Traits;

use DB;
use App\Models\SupplyReturn;
use App\Models\CashReturn;
use App\Models\ReturnPurchase;
use App\Models\Returnsale;
use Illuminate\Http\Request;
trait ReturnTrait
{

    public function create(Request $request)
    {


        // return response()->json($request->post('date'));
        $data = $request->post('old');
        $return_data = $request->post('return_qty');
        $type = $request->post('type');
        $type_refresh = $request->post('type_refresh');



        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

        foreach ($data as  $value) {

            if ($value['qty_remain'] > $value['avilable_qty']) {


                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"]);
            } elseif ($value['qty_remain'] > $value['qty']) {

                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المورده"]);
            } elseif ($value['qty_remain'] == 0) {

                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
            }
        }


        // -----------------------------------------------------------------------------------------------------------------------------------------------------------------
        $tables = '';
        switch ($type) {


            case 'return_supply':
                $return = new SupplyReturn();
                $return->supply_id = $request->post('id'); #this equal supply_id
                $tables = 'supplies';

                break;

            case 'return_cash':

                $return = new CashReturn();
                $return->cash_id = $request->post('id');#this equal cash_id
                $tables = 'cashes';
                break;
            case 'return_purchase':

                $return = new ReturnPurchase();
                $return->purchase_id = $request->post('id');
                $tables = 'purchases';
                break;

            case 'return_sale':

                $return = new ReturnSale();
                $return->sale_id = $request->post('id');
                $tables = 'sales';

                break;

            default:
                break;
        }

        $return->date  = $request->post('date');
        $return->quantity = $request->post('total');
        $return->note  = $request->post('note');
        $return->save();

        // -----------------------------------------------------------------------------------------------------------------------------------------------------------------


        // switch ($type) {


        //     case 'return_supply':
        //         DB::table($tables)
        //         ->where('id', $request->post('supply_id'))
        //         ->increment('qty_return', $request->post('total'));

        //         break;

        //     case 'return_cash':

        //         DB::table($tables)
        //         ->where('id', $request->post('cash_id'))
        //         ->increment('qty_return', $request->post('total'));


        //         break;


        //     case 'return_purchase':
        //         DB::table($tables)
        //         ->where('id', $request->post('purchase_id'))
        //         ->increment('qty_return', $request->post('total'));


        //         break;



        //     case 'return_sale':

        //         DB::table($tables)
        //         ->where('id', $request->post('sale_id'))
        //         ->increment('qty_return', $request->post('total'));


        //         break;


        //     default:
        //         break;
        // }

        // // // -----------------------------------------------------------------------------------------------------------------------------------------------------------------

        // foreach ($return_data as $key_qty => $value_qty) {

        // //     // return response()->json(['data'=> $value_qty]);

        //     if ($value_qty != null) {


        //         foreach ($data as  $value) {

        //             if ($value_qty['product_id'] == $value['product_id'] && $value_qty['store_id'] == $value['store_id'] && $value_qty['status_id'] == $value['status_id'] && $value_qty['desc'] == $value['desc']) {


        // //                 // -------------------------------------------------------------------------------------------------
        //                 $stock_f = 0;
        //                 $store_product_f = 0;

        //                 $store_product_f = $this->refresh_store($value,$type,$type_refresh);

        // //                 //----------------------------------------------------------------------------------------------------------------------------------------- 

        //                 $id_store_product = $this->get($value);


        //                 foreach ($id_store_product as $values) {


        //                     $id_store_product = $values['id'];
        //                 }

        // //                 if ($store_product_f == 0) {

        // //                     $id_store_product = $this->init_store($value,$type);
        // //                     // return response()->json(['id_store_product'=>'muhib']);


        // //                 }

        // //                 // return response()->json(['id_store_product'=> $id_store_product]);

        // //                 //----------------------------------------------------------------------------------------------------------------------------------------- 
        // //                 $this->init_details($return->id, $id_store_product, $value,$type, $request->all());

        // //                 // -------------------------------------------------------------------------------------------------

        // //                 SupplyDetail::wheresupply($value)->increment('qty_return', $value_qty['qty']);

        // //                 // -------------------------------------------------------------------------------------------------

        // //                 $stock_f = $this->refresh_stock($return->id, $value,$type, 'decrement');

        // //                 // -------------------------------------------------------------------------------------------------


        // //                 if ($stock_f == 0) {

        // //                     $this->init_stock($return->id, $value,$type, $request->post('date'));
        // //                 }

        // //                 // -------------------------------------------------------------------------------------------------
        //             }
        //         }
        //     }
        // }

        return response()->json($request->post('total'));
    }
}
