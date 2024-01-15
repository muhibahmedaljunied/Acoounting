<?php

namespace App\Services;

class CoreService
{
    public $id_store_product;
    public $data_store_product;
    public $store_product_f = 0;
    public $micro_unit_qty;
    public $unit_value;
    public $unit_array;
    public $daily_id = 0;
    public $stock_f = 0;
    public $data;
    public $sale_id;
    public $sale;
    public $cash_id;
    public $cash;
    public $return;
    public $return_id;
    public $purchase_id;
    public $purchase;
    public $supply_id;
    public $supply;
    public $transfer_id;
    public $transfer;

    public $value;
    public $discount;

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
