<?php

namespace App\Services;

// use App\Traits\DailyTrait;
use App\Models\PaymentCash;

class CashPaymentService
{
    // public $request;
    // public $cash_id = 0;
    // public $temporale = 0;
    // public $discount;

    // use DailyTrait;
    public function __construct(


        protected CoreService $core,


    ) {
    }


    public function pay()
    {



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


        // if ($this->core->data['paid'] == 0) { $payment_status = 'pendding';}
        // if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {$payment_status = 'partially';}
        // $payment_info = ($this->core->data['remaining'] == 1) ? $this->core->data['type'] : $payment_info = 'credit' ;
        $payment = new PaymentCash();
        $payment->cash_id = $this->core->cash_id;
        // $payment->payment_info = $payment_info;
        $payment->payment_status = $payment_status;
        $payment->paid = $this->core->data['paid'];
        $payment->remaining = $this->core->data['remaining'];
        $payment->save();

        return $this;
    }

    
    public function update_receivableBond()
    {


        $payment = PaymentCash::get()
            ->where('cash_id', $this->core->data['cash_id'])
            ->first();

        $this->core->data['paid'] = $this->core->data['paid'] + $payment->paid;

        // dd($this->core->data['paid'] );
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

        // $payment = PaymentCash::get()
        //     ->where('cash_id', $this->core->data['cash_id'])
        //     ->first();

        // dd($payment);
    }
    
}
