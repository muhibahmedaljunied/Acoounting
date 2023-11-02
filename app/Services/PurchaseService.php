<?php

namespace App\Services;
use App\Services\StoreService;
use App\Services\InventureService;
use App\Services\StockService;
// use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;
use App\Models\PaymentPurchase;

// use App\Traits\DailyTrait;

class PurchaseService
{

    // use DailyTrait;
    public $purchase_id;
    public $discount;
    public $message;
    public $status_request = 'faild';
    public $id;

    public function __construct(
        protected InventureService $inventury,
        protected CoreService $core,


    ) {
  
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }


   


    // public function Stock()
    // {

    //     $this->inventury->refresh_price(); //this make refresh for cost of product

    //     $this->stock->init_stock();
    // }
    // public function store()
    // {

    //     $this->store->get_store('purchase');
    //     $this->store->refresh_store();
    //     $this->store->init_store(); // this make refresh for store_products

    // }

    // public function unit_and_qty()
    // {

    //     // this make decode for unit and convert qty into miqro
    //     $this->unit->decode_unit();
    //     $this->unit->convert_qty();

    // }



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
