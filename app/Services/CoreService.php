<?php

namespace App\Services;
class CoreService extends CoreDailyService
{
    public $id_store_product;
    public $data_store_product;
    public $store_product_f = 0;
    public $micro_unit_qty;

    // public $unit_value;
    public $unit_array;
    public $daily_id = 0;
    public $stock_f = 0;
    public $data;
    public $sale_id;
    public $cash_id;
    public $return_id;
    public $purchase_id;
    public $supply_id;
    public $transfer_id;
    public $paymentable;
    public $stockable;
    public $value;
    public $discount;
    public $core_daily;

    

    // public function __construct()
    // {
    //     $this->core_daily = app(CoreDailyService::class);

    // }
    public function setValue($value)
    {

        $this->value = $value;
    }

    public function setData($data)
    {

        $this->data = $data;
    }

    public function setDiscount($discount)
    {

        $this->discount = $discount;
    }
}
