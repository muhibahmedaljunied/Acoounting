<?php

namespace App\Traits;

use App\Traits\ConditionTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Traits\StoreProduct\StoreTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Traits\Details\DetailsTrait;
use App\Traits\Return\ReturnTrait;
use App\Models\Temporale;
use App\Models\Supply;
use App\Models\PaymentSale;
use App\Models\PaymentPurchase;
use App\Models\Cash;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait GeneralTrait
{
    use TemporaleTrait, StoreTrait, StockTrait, StoreProductTrait, ConditionTrait, DetailsTrait,ReturnTrait;
    public function store(Request $request)
    {

        // return response()->json(['message' => $request->all()]);
        foreach ($request->post('count') as $value) {

            $temporale_f = 0;
            // if ($value !== null) {
            if ($request->post('type') == 'Supply' || $request->post('type') == 'Cash') {

                $temporale_f = tap(Temporale::whereall($request->all(), $value, $request->post('type')))
                    ->update(['qty' => $request->post('qty')[$value],'price' => $request['price'][$value]])
                    ->get('id');
            } 
            else {
                $temporale_f = tap(
                    Temporale::whereall($request->all(), $value, $request->post('type'))
                )
                    ->update(['qty' => $request['qty'][$value], 'price' => $request['price'][$value], 'tax' => $request['tax'][$value]])
                    ->get('id');

                    
            }


            if (count($temporale_f) == 0) {

           
              $this->add_temporale($request->all(), $value, $request->post('type'));
            }
            // }
        }


        return response()->json(['message' => $request->all()]);
    }

    public function payment(Request $request)
    {

        // return response()->json(['message' => $request->all()]);
        $supplier_name = $request->post('supplier_name');
        $supplier_id = $request->post('supplier_id');
        $customer_name = $request->post('customer_name');
        $customer_id = $request->post('customer_id');
        // return response()->json(['message' => [$customer_name,$customer_id]]);
        $discount = $request->post('discount') * $request->post('total') / 100;

        // ----------------------this add data into supply ,cash,sale,purchase------here started--------------------
        switch ($request->post('type')) {
            case 'Supply':
                $table_one = new Supply();
                $table_one->supplier_id =  $supplier_id;
                $table_one->supplier_name =  $supplier_name;
                break;
            case 'Cash':
                $table_one = new Cash();
                $table_one->customer_id =  $customer_id;
                $table_one->customer_name =  $customer_name;
                break;

            case 'Purchase':

                $table_one = new Purchase();
                $table_one->supplier_id =  $supplier_id;
                $table_one->supplier_name =  $supplier_name;
                $table_one->grand_total  = $request->post('grand_total');
                $table_one->sub_total  = $request->post('sub_total');
                $table_one->discount = $discount;
                $table_one->tax_amount  = $request->post('total_tax');
                $table_one->status = 'pendding';
                break;

            case 'Sale':
                $table_one = new Sale();
                $table_one->customer_id =  $customer_id;
                $table_one->customer_name =  $customer_name;
                $table_one->grand_total  = $request->post('grand_total');
                $table_one->sub_total  = $request->post('sub_total');
                $table_one->discount = $discount;
                $table_one->tax_amount  = $request->post('total_tax');
                $table_one->status = 'pendding';
                break;
        }
        
        $table_one->date =  $request->post('date');
        $table_one->save();



        // -----------------------------------------------here ended-----------------------------------
        $temporale = $this->check_temporale($request->post('type'));
        // return response()->json(['message' => $temporale]);
        if (count($temporale) != 0) {

            if ($request->post('type') == 'Sale' || $request->post('type') == 'Purchase') {

                if ($request->post('type') == 'Sale') {

                    $payment = new PaymentSale();
                    $payment->sale_id = $table_one->id;
                } else {
                    $payment = new PaymentPurchase();
                    $payment->purchase_id = $table_one->id;
                }

                $payment->payment_info = $request->post('type');

            

                if($request->post('paid') == 0 ){$payment->payment_status = 'pendding';}
                if($request->post('remaining') == 0 ){$payment->payment_status = 'paiding';}
                if($request->post('paid') != 0 && $request->post('remaining') != 0 ){$payment->payment_status = 'Partially';}
                // $payment->payment_status = 'pendding';
                $payment->paid = $request->post('paid');
                $payment->remaining = $request->post('remaining');

                if ($request->post('remaining') == 1) {


                    $payment->payment_info = $request->post('type');
                } else {
 

                    $payment->payment_info = 'credit';
                }
                $payment->save();
            }




            // ----------------------------------------------------------------------------------------

            foreach ($temporale as $value) {

                $stock_f = 0;
                $store_product_f = 0;



                $store_product_f = $this->refresh_store($value,$request->post('type_refresh')); // this make updating for store_products
                // return response()->json(['message' => $store_product_f]);
                $id_store_product = $this->get($value);  //this get data from store_products


                foreach ($id_store_product as $values) {


                    $id_store_product = $values['id'];
                }
                //----------------------------------------------------------------------------------------------------------------------------------------- 


                if ($store_product_f == 0) {


                    $id_store_product = $this->init_store($value, $request->post('type')); // this make intial for store_products if it is empty
                }

                $this->init_details($table_one->id, $id_store_product, $value, $request->post('type'), $request->all()); // this make initial for details tables

                $stock_f = $this->refresh_stock($table_one->id, $value, $request->post('type'), $request->post('type_refresh')); // this make update for stock table

                if ($stock_f == 0) {

                    $this->init_stock($table_one->id, $value, $request->post('type'), $request->post('date')); //this make intial for stock table if it is empty 
                }
            }

            Temporale::where('type_process', $request->post('type'))->delete(); //this removes data from temporale table after moving it 
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'faild']);
    }

    public function create(Request $request)   // this create return for supply,cashing,sale,purchase
    {

        $data = $request->post('old');
        
        // return response()->json(['message' => $request->all()]);

        // -------------------------------------------- this check if qty_return greater than quantity or qty_avilable-----------------------------------------------------

        foreach ($data as  $key => $value) {

           

            $qty_remain = $value['qty_remain'];
            $qty = $value['qty'];

            foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

                if($value['unit'] == $values['name'] && $values['unit_type'] == 1){

                    
                    $qty_remain = $value['qty_remain']*$value['rate'];
                    $qty = $value['qty']*$value['rate'];

                }

            }
            // -------------------------------------------------------------------------------------------------------------------
        
            if ($qty_remain > $value['avilable_qty']) {


                if($request->post("type") == 'PurchaseReturn'){

                    return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"]);

                }

            }
            if ($qty_remain > $qty && $request->post("type") == 'SaleReturn') {

                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المباعه"]);
            } 

            if ( $qty_remain > $qty && $request->post("type") == 'PurchaseReturn') {

                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المورده"]);
            }
            if ($qty_remain == 0) {

                return response()->json(['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"]);
            }
        }
        // return response()->json(['message' => intval($qty)]);
        // -------------------------------------------------------------------------------------------------
        
        $return = $this->store_return($request->all());
       
        // -------------------------------------------------------------------------------------------------
        
        foreach ($request->post('count') as $value) {

            $stock_f = 0;


            $micro_unit_qty = $this->unit($request->all(),$value);
            // return response()->json(['message' => $micro_unit_qty]);
            $this->refresh_store_from_return($value,$request->all(),$micro_unit_qty); // this make updating for store_products
            $id_store_product = $this->get($value,$request->all());  //this get data from store_products


            //----------------------------------------------------------------------------------------------------------------------------------------- 

            foreach ($id_store_product as $values) {


                $id_store_product = $values['id'];
            }
            
            //----------------------------------------------------------------------------------------------------------------------------------------- 
            $this->init_details($return->id, $id_store_product, $value,$request->post("type"), $request->all()); // this make initial for details tables
            //----------------------------------------------------------------------------------------------------------------------------------------- 

            $stock_f = $this->refresh_stock($return->id, $value, $request->post('type'), $request->post('type_refresh'),$request->all()); // this make update for stock table
            //----------------------------------------------------------------------------------------------------------------------------------------- 

            $this->refresh_details($request->all(),$value);
            //----------------------------------------------------------------------------------------------------------------------------------------- 

            if ($stock_f == 0) {

                 $this->init_stock($return->id, $value, $request->post('type'), $request->post('date'),$request->all()); //this make intial for stock table if it is empty 
            }
        }
        
        return response()->json(['message' => 'success']);
    }

    public function unit ($request,$value){

        
        foreach ($request['old'] as $key => $values) {   //this for converts qty_avaliable into big unit

            $micro_unit_qty = $request['qty'][$value];

            if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 1){

                    
                 $micro_unit_qty = $request['qty'][$value]*$request['unit_id'][$value][1]; 
    
            }

            if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 0){

                    
                  $micro_unit_qty = $request['qty'][$value];
    
            }

        }

        return $micro_unit_qty;



    }
}
