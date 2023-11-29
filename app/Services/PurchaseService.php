<?php

namespace App\Services;
use App\Services\CoreService;
use App\Models\PaymentPurchase;
class PurchaseService
{


    public $purchase_id;
    public $discount;
    public $message;
    public $status_request = 'faild';
    public $id;

    public function __construct(
        protected CoreService $core,


    ) {
  
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }

    public function pay()
    {

        $payment_status = 'pendding';
        $payment_info = $this->core->data['type'];
        if ($this->core->data['paid'] == 0) {
            $payment_status = 'pendding';
        }
        if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {
            $payment_status = 'Partially';
        }
        ($this->core->data['remaining'] == 1) ? $payment_info = $this->core->data['type'] : $payment_info = 'credit';
        $payment_status = 'paiding';
        // -----------------------------------------------------------------------------------------

        $payment = PaymentPurchase::create(
            [
                'purchase_id' => $this->core->purchase_id,
                'payment_info' => $payment_info,
                'payment_status' => $payment_status,
                'paid' => $this->core->data['paid'],
                'remaining' => $this->core->data['remaining'],

            ]
        );

        // return $payment->id;
        return $this;
    }
}
