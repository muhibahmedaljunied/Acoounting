<?php

namespace App\Services;
use App\Traits\DailyTrait;
use App\Models\PaymentSale;
class SaleService 
{
    public $request;
    public $sale_id = 0;
    public $temporale = 0;
    public $discount;

    use DailyTrait;
    public function __construct(
    
       
        protected CoreService $core,


    ) {

    }

   
    public function pay(){


        $payment_status = 'pendding';
        $payment_info = $this->core->data['type'];
        if ($this->core->data['paid'] == 0) { $payment_status = 'pendding';}
        if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {$payment_status = 'Partially';}
        ($this->core->data['remaining'] == 1) ? $payment_info = $this->core->data['type'] : $payment_info = 'credit' ;$payment_status = 'paiding';
        $payment = new PaymentSale();
        $payment->sale_id = $this->core->sale_id;
        $payment->payment_info = $payment_info;
        $payment->payment_status = $payment_status;
        $payment->paid = $this->core->data['paid'];
        $payment->remaining = $this->core->data['remaining'];
        $payment->save();
        // return $payment->id;
        return $this;

    }

   
}
