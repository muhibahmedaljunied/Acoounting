<?php

namespace App\Traits;

use App\Traits\ConditionTrait;

use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Traits\Details\DetailsTrait;
use App\Traits\Return\ReturnTrait;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\PaymentPurchase;
use App\Models\PaymentSale;
use App\Models\Supply;
use App\Models\Cash;
use App\Models\Transfer;



trait GeneralTrait
{
    use StockTrait, StoreProductTrait, ConditionTrait, DetailsTrait, ReturnTrait;


    public function add($data,$discount=null)
    {


        switch ($data['type']) {

            case 'Supply':

                $table_one = Supply::create(
                    [
                        'supplier_id' => $data['supplier_id'],
                        'supplier_name' => $data['supplier_name']
                    ]
                );
                break;
            case 'Cash':
                $table_one = new Cash();
                $table_one->customer_id =  $data['customer_id'];
                $table_one->customer_name =  $data['customer_name'];
                break;

            case 'Purchase':

                $table_one = Purchase::create(
                    [
                        'supplier_id' => $data['supplier_id'],
                        'supplier_name' => $data['supplier_name'],
                        'grand_total' => $data['grand_total'],
                        'sub_total' => $data['sub_total'],
                        'discount' => $discount,
                        'tax_amount' => $data['total_tax'],
                        'status' => 'pendding',

                    ]
                );


                break;

            case 'Sale':
                $table_one = new Sale();
                $table_one->customer_id =  $data['customer_id'];
                $table_one->customer_name =  $data['customer_name'];
                $table_one->grand_total  = $data['grand_total'];
                $table_one->sub_total  = $data['sub_total'];
                $table_one->discount = $discount;
                $table_one->tax_amount  = $data['total_tax'];
                $table_one->status = 'pendding';
                break;
            case 'Transfer':
                $table_one = new Transfer();
                break;    

        }

 
        $table_one->date =  $data['date'];
        $table_one->save();
        return $table_one->id;
    }

    public function pay($data, $id)
    {

        $payment_status = 'pendding';
        $payment_info = $data['type'];
        if ($data['paid'] == 0) { $payment_status = 'pendding';}
        if ($data['paid'] != 0 && $data['remaining'] != 0) {$payment_status = 'Partially';}
        ($data['remaining'] == 1) ? $payment_info = $data['type'] : $payment_info = 'credit' ;$payment_status = 'paiding';
        // -----------------------------------------------------------------------------------------
        $payment = ($data['type'] == 'Purchase') ? $this->payment_purchase() : $this->payment_sale() ;
        
        $payment = new PaymentPurchase();
        $payment->purchase_id = $id;
        $payment->payment_info = $payment_info;
        $payment->payment_status = $payment_status;
        $payment->paid = $data['paid'];
        $payment->remaining = $data['remaining'];
        $payment->save();
        return $payment->id;
    }


    // public function payment_purchase($core)
    // {

    //     $payment_status = 'pendding';
    //     $payment_info = $core->data['type'];
    //     if ($core->data['paid'] == 0) { $payment_status = 'pendding';}
    //     if ($core->data['paid'] != 0 && $core->data['remaining'] != 0) {$payment_status = 'Partially';}
    //     ($core->data['remaining'] == 1) ? $payment_info = $core->data['type'] : $payment_info = 'credit' ;$payment_status = 'paiding';
    //     // -----------------------------------------------------------------------------------------

    //     $payment = PaymentPurchase::create(
    //         [
    //             'purchase_id' => $core->purchase_id,
    //             'payment_info' => $payment_info,
    //             'payment_status' => $payment_status,
    //             'paid' => $core->data['paid'],
    //             'remaining' => $core->data['remaining'],

    //         ]
    //     );

    //     return $payment->id;
    // }
    // public function payment_sale($core)
    // {


    //     $payment_status = 'pendding';
    //     $payment_info = $core->data['type'];
    //     if ($core->data['paid'] == 0) { $payment_status = 'pendding';}
    //     if ($core->data['paid'] != 0 && $core->data['remaining'] != 0) {$payment_status = 'Partially';}
    //     ($core->data['remaining'] == 1) ? $payment_info = $core->data['type'] : $payment_info = 'credit' ;$payment_status = 'paiding';
    //     $payment = new PaymentSale();
    //     $payment->sale_id = $core->sale_id;
    //     $payment->payment_info = $payment_info;
    //     $payment->payment_status = $payment_status;
    //     $payment->paid = $core->data['paid'];
    //     $payment->remaining = $core->data['remaining'];
    //     $payment->save();
    //     return $payment->id;
    // }


    public function unit($data, $value)
    {


        return $data;
        foreach ($data as $key => $values) {   //this for converts qty_avaliable into big unit

            $micro_unit_qty = $data['qty'];

            if ($values['units']['name'] == $values['unit'] && $values['units']['unit_type'] == 1) {


                $micro_unit_qty = $data['qty'] * $data['unit_id'][1];
            }

            if ($values['units']['name'] == $values['unit'] && $values['units']['unit_type'] == 0) {


                $micro_unit_qty = $data['qty'];
            }
        }

        return $micro_unit_qty;
    }
}
