<?php

namespace App\Services;

use App\Services\CoreService;
use App\Models\PaymentPurchase;

class PurchasePaymentService
{


    // public $purchase_id;
    // public $discount;
    // public $message;
    // public $status_request = 'faild';
    // public $id;

    public function __construct(
        protected CoreService $core,


    ) {

        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }

    public function pay()
    {

        // dd($this->core->data);
        // $payment_status = 'pendding';
        // $payment_info = $this->core->data['type'];

        if ($this->core->data['type_payment'] == 1) {
          
            $payment_status = 'paiding';
        }
        if ($this->core->data['type_payment'] == 2) {
          
            if ($this->core->data['paid'] == 0) {
            
                $payment_status = 'pendding';
            }
            if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {
                $payment_status = 'partially';
            }


        }

        // ($this->core->data['remaining'] == 1) ? $payment_info = $this->core->data['type'] : $payment_info = 'credit';
        // $payment_status = 'paiding';
        // -----------------------------------------------------------------------------------------

        PaymentPurchase::create(
            [
                'purchase_id' => $this->core->purchase_id,
                // 'payment_info' => $payment_info,
                'payment_status' => $payment_status,
                'paid' => $this->core->data['paid'],
                'remaining' => $this->core->data['remaining'],

            ]
        );
        return $this;
    }


    public function update_paymentBond()
    {



        $payment = PaymentPurchase::get()
            ->where('purchase_id', $this->core->data['purchase_id'])
            ->first();

        $this->core->data['paid'] = $this->core->data['paid'] + $payment->paid;

        if ($this->core->data['remaining'] == 0) {
            $array_data = [
                'payment_status' => 'paiding',
                'paid' => $this->core->data['paid'],
                'remaining' => $this->core->data['remaining']

            ];
        }
        if ($this->core->data['remaining'] > 0) {
            $array_data = [
                'payment_status' => 'partialy',
                'paid' => $this->core->data['paid'],
                'remaining' => $this->core->data['remaining']
            ];
        }

        $payment->update($array_data);

        // $payment = PaymentPurchase::get()
        //     ->where('purchase_id', $this->core->data['purchase_id'])
        //     ->first();

        // dd($payment);
    }
}
